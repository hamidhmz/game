var app = require('express')();
var http = require('http').Server(app).listen(82);
var io = require('socket.io')(http);
var mysql = require('mysql');
var game_server = require('./game');
var users = {};
var game_servers = {};
var lig_game_servers = {};
var db_config = {host: '127.0.0.1', user: 'root', password: '', database: 'backgammon'};
var con;

var myIntervals = {};
var myTimeouts = {};
var mydtIntervals = {};
var dts = {}; // disconnect times

var ligMyIntervals = {};
var ligMyTimeouts = {};
var ligMydtIntervals = {};
var ligDts = {}; // disconnect times

var dt = 60000; // disconnect time
var ct = 20000; // current time
var et = ct + 2000; // end time

handleDisconnect(1);

ligs();

settings();

io.on('connection', function (socket) {
    var user_id = null;
    var game_id = null;
    // Pages
    socket.on('site_index', function (username, password) {
        login(username, password, 'site_index', function () {});
    });
    socket.on('games_create', function (username, password) {
        login(username, password, 'games_create', function () {});
    });
    socket.on('games_history', function (username, password) {
        login(username, password, 'games_history', function () {});
    });
    socket.on('games_index', function (username, password) {
        login(username, password, 'games_index', function () {
            socket.emit('games list', gamesList());
        });
    });
    socket.on('games_play', function (username, password, gid) {
        login(username, password, 'site_index', function () {
            if (!isGameIdValid(gid, user_id)) {
                socket.emit('message', 'wrong game id', {gid: gid});
                return;
            }
            var mygameserver = game_servers[gid];
            var board_id = mygameserver.board_id;
            var player1_id = mygameserver.player1.id;
            var player2_id = mygameserver.player2.id;
            var player1_fullname = mygameserver.player1.fullname;
            var player2_fullname = mygameserver.player2.fullname;
            var current_player_id = mygameserver.currentPlayer.id;
            var availableMovesLength = mygameserver.availableMoves();
            var diceRoller = mygameserver.diceRoller;
            var total_amount = mygameserver.total_amount;
            var points = getPoints(mygameserver);
            var names = [player1_fullname, player2_fullname];
            var currentPlayerType = (current_player_id == player1_id ? 0 : 1);
            var myType = (user_id == player1_id ? 0 : 1);
            getDices(board_id, function (dices_count) {
                getWins(gid, player1_id, player2_id, function (wins_player1, wins_player2) {
                    var response = {
                        dices_count: dices_count,
                        wins: [wins_player1, wins_player2],
                        names: names,
                        currentPlayer: currentPlayerType,
                        type: myType,
                        availableMoves: availableMovesLength,
                        points: points,
                        diceRoller: diceRoller,
                        amount: total_amount
                    };
                    socket.emit("let's play", response);
                    var opponentSocket = getSocketByUserId(user_id == player1_id ? player2_id : player1_id);
                    if (opponentSocket) {
                        opponentSocket.emit('opponent connected');
                        socket.emit('opponent connected');
                    }
                    else {
                        socket.emit('opponent disconnected');
                    }
                    game_id = gid;
                });
            });
        });
    });
    socket.on('games_view', function (username, password, gid) {
        login(username, password, 'site_index', function () {
            if (typeof gid !== 'string' || !isNumber(gid)) {
                socket.emit('message', 'wrong game id', {gid: gid});
                return;
            }
            var sql = '';
            sql += 'SELECT games.amount, games.total_amount, games.type_id, games_types.title as type_title ';
            sql += 'FROM games ';
            sql += 'INNER JOIN games_types ON games.type_id=games_types.id ';
            sql += 'WHERE games.id=? AND games.player_1=? AND status_id=1';
            Q(sql, [gid, user_id], function (err, res) {
                if (res && res[0]) {
                    socket.emit('games list', gamesList());
                    if (!game_servers[gid]) {
                        var game_row = res[0];
                        var game_amount = game_row.amount;
                        var game_total_amount = game_row.total_amount;
                        var game_type_id = game_row.type_id;
                        var game_type_title = game_row.type_title;
                        var user = users[user_id];
                        var player = new game_server.Player(user.id, user.fullname);
                        var mygameserver = new game_server.Game();
                        mygameserver.setPlayer(1, player);
                        mygameserver.id = gid;
                        mygameserver.amount = game_amount;
                        mygameserver.total_amount = game_total_amount;
                        mygameserver.type_id = game_type_id;
                        mygameserver.type_title = game_type_title;
                        mygameserver.status_id = 1;
                        game_servers[gid] = mygameserver;
                        io.emit('games list', gamesList());
                        io.to('admin_site_index').emit('games count', game_servers);
                    }
                }
                else {
                    socket.emit('message', 'wrong game id', {gid: gid});
                }
            });
        });
    });
    socket.on('ligs_play', function (username, password, gid) {
        login(username, password, 'ligs_play', function () {
            if (!isGameIdValidForLig(gid, user_id)) {
                socket.emit('message', 'wrong game id', {gid: gid});
                return;
            }

            var mygameserver = lig_game_servers[gid];
            var board_id = mygameserver.board_id;
            var player1_id = mygameserver.player1.id;
            var player2_id = mygameserver.player2.id;
            var player1_fullname = mygameserver.player1.fullname;
            var player2_fullname = mygameserver.player2.fullname;
            var current_player_id = mygameserver.currentPlayer.id;
            var availableMovesLength = mygameserver.availableMoves();
            var diceRoller = mygameserver.diceRoller;
            var total_amount = mygameserver.total_amount;
            var points = getPoints(mygameserver);
            var names = [player1_fullname, player2_fullname];
            var currentPlayerType = (current_player_id == player1_id ? 0 : 1);
            var myType = (user_id == player1_id ? 0 : 1);
            getDices(board_id, function (dices_count) {
                getWins(gid, player1_id, player2_id, function (wins_player1, wins_player2) {
                    var response = {
                        dices_count: dices_count,
                        wins: [wins_player1, wins_player2],
                        names: names,
                        currentPlayer: currentPlayerType,
                        type: myType,
                        availableMoves: availableMovesLength,
                        points: points,
                        diceRoller: diceRoller,
                        amount: total_amount
                    };
                    socket.emit("let's play", response);
                    var opponentSocket = getSocketByUserId(user_id == player1_id ? player2_id : player1_id);
                    if (opponentSocket) {
                        opponentSocket.emit('opponent connected');
                        socket.emit('opponent connected');
                    }
                    else {
                        socket.emit('opponent disconnected');
                    }
                    game_id = gid;
                });
            });
        });
    });
    socket.on('ligs_view', function (username, password) {
        login(username, password, 'ligs_view', function () {});
    });
    socket.on('admin_site_index', function (username, password) {
        login(username, password, 'admin_site_index', function () {});
    });
    // Actions
    socket.on('cancel game', function (gid) {
        if (!isGameIdValidToCancel(gid, user_id)) {
            socket.emit('message', 'wrong game id', {gid: gid});
            return;
        }
        Q('UPDATE games SET status_id=4 WHERE id=' + gid, function () {
            deposit(game_servers[gid].amount, user_id);
            delete game_servers[gid];
            io.emit('games list', gamesList());
            io.to('admin_site_index').emit('games count', game_servers);
            socket.emit('go', 'index');
        });
    });
    socket.on('join game', function (gid) {
        if (!isGameIdValidToJoin(gid, user_id)) {
            socket.emit('message', 'wrong game id', {gid: gid});
            return;
        }
        var user = users[user_id];
        var amount = game_servers[gid].amount;
        var credit = user.credit;
        if (amount > credit) {
            socket.emit('message', 'low cost', {amount: amount, credit: credit});
            return;
        }

        Q('SELECT * FROM games WHERE status_id=1 AND player_1=?', [user_id], function (err, res) {
            if (res && res.length) {
                for (var item in res) {
                    var row = res[item];
                    if (game_servers[row.id.toString()]) {
                        Q('DELETE FROM games WHERE id=?', [row.id]);
                        Q('UPDATE users SET credit = credit + ? WHERE id=?', [row.amount, user_id]);
                        delete game_servers[row.id.toString()];
                    }
                }
            }
        });

        var player = new game_server.Player(user.id, user.fullname);
        game_servers[gid].setPlayer(2, player);
        game_servers[gid].status_id = 2;
        socket.broadcast.emit('games list', gamesList());
        io.to('admin_site_index').emit('games count', game_servers);
        startGame(gid, user.id);
        reduceCredit(credit - amount, user_id);
        setBoard(gid, function (board_id) {
            game_servers[gid].board_id = board_id;
            game_servers[gid].start();
            var current_player_id = game_servers[gid].currentPlayer.id;
            var firstValue = game_servers[gid].diceRoller.firstValue;
            var secondValue = game_servers[gid].diceRoller.secondValue;
            setDices(board_id, current_player_id, firstValue, secondValue, function (dice_id) {
                game_servers[gid].dice_id = dice_id;
                var player1_id = game_servers[gid].player1.id;
                var player1Socket = getSocketByUserId(player1_id);
                if (player1Socket) {
                    player1Socket.emit('go', 'play');
                }
                socket.emit('pre play', gid);
                game_servers[gid].canMoveChecker = true;
                setTimer(gid);
            });
        });
    });
    socket.on('do move', function (data) {
        var gid = data.gid;
        var source = data.source;
        var target = data.target;
        if (!isGameIdValid(gid, user_id)) {
            return;
        }
        if (game_servers[gid].currentPlayer.id !== user_id) {
            return;
        }
        if (!game_servers[gid].canMoveChecker) {
            return;
        }

        var dice_id = game_servers[gid].dice_id;
        var player1_id = game_servers[gid].player1.id;
        var player2_id = game_servers[gid].player2.id;
        var current_player_id = game_servers[gid].currentPlayer.id;
        var currentPlayerType = current_player_id == player1_id ? 0 : 1;
        if (game_servers[gid].canMove(source, target)) {
            var distance = game_servers[gid].moveChecker(source, target);
            setPlay(dice_id, source, target, distance);
            var availableMoves = game_servers[gid].availableMoves();
            var points = getPoints(game_servers[gid]);
            var response = {currentPlayer: currentPlayerType, availableMoves: availableMoves, points: points};
            var player1Socket = getSocketByUserId(player1_id);
            if (player1Socket) {
                player1Socket.emit('redraw checkers', response);
            }
            var player2Socket = getSocketByUserId(player2_id);
            if (player2Socket) {
                player2Socket.emit('redraw checkers', response);
            }
        }
        else {
            var points = getPoints(game_servers[gid]);
            var availableMoves = game_servers[gid].availableMoves();
            var response = {currentPlayer: currentPlayerType, points: points, availableMoves: availableMoves};
            socket.emit('redraw checkers', response);
        }
    });
    socket.on('undo', function (gid) {
        if (!isGameIdValid(gid, user_id)) {
            return;
        }

        if (game_servers[gid].currentPlayer.id !== user_id) {
            return;
        }

        game_servers[gid].undo();

        var player1_id = game_servers[gid].player1.id;
        var player2_id = game_servers[gid].player2.id;
        var current_player_id = game_servers[gid].currentPlayer.id;
        var currentPlayerType = current_player_id == player1_id ? 0 : 1;

        var availableMoves = game_servers[gid].availableMoves();
        var points = getPoints(game_servers[gid]);
        var response = {currentPlayer: currentPlayerType, availableMoves: availableMoves, points: points};

        var player1Socket = getSocketByUserId(player1_id);
        if (player1Socket) {
            player1Socket.emit('redraw checkers', response);
        }
        var player2Socket = getSocketByUserId(player2_id);
        if (player2Socket) {
            player2Socket.emit('redraw checkers', response);
        }
    });
    socket.on('handover', function (gid) {

        if (!isGameIdValid(gid, user_id)) {
            return;
        }

        game_servers[gid].canMoveChecker = false;

        if (myIntervals[gid]) {
            clearInterval(myIntervals[gid]);
        }
        if (myTimeouts[gid]) {
            clearTimeout(myTimeouts[gid]);
        }
        if (mydtIntervals[gid]) {
            clearInterval(mydtIntervals[gid]);
        }


        if (game_servers[gid].player1.id == user_id) {
            var player2 = game_servers[gid].player2;
            var home = game_servers[gid].player2Home;
            var count = home.checkersCount();
            for (var i = 0, max = 15 - count; i < max; i++) {
                var checker2 = new game_server.Checker(player2);
                game_servers[gid].player2Home.addChecker(checker2);
            }
        }
        else if (game_servers[gid].player2.id == user_id) {
            var player1 = game_servers[gid].player1;
            var home = game_servers[gid].player1Home;
            var count = home.checkersCount();
            for (var i = 0, max = 15 - count; i < max; i++) {
                var checker1 = new game_server.Checker(player1);
                game_servers[gid].player1Home.addChecker(checker1);
            }
        }

        finishTurn(gid);

    });
    socket.on('lig do move', function (data) {
        ligDoMove(socket, data, user_id);
    });
    socket.on('lig undo', function (gid) {
        if (!isGameIdValidForLig(gid, user_id)) {
            return;
        }
        if (lig_game_servers[gid].currentPlayer.id !== user_id) {
            return;
        }
        lig_game_servers[gid].undo();
        var player1_id = lig_game_servers[gid].player1.id;
        var player2_id = lig_game_servers[gid].player2.id;
        var current_player_id = lig_game_servers[gid].currentPlayer.id;
        var currentPlayerType = current_player_id == player1_id ? 0 : 1;
        var availableMoves = lig_game_servers[gid].availableMoves();
        var points = getPoints(lig_game_servers[gid]);
        var response = {currentPlayer: currentPlayerType, availableMoves: availableMoves, points: points};
        var player1Socket = getSocketByUserId(player1_id);
        if (player1Socket) {
            player1Socket.emit('redraw checkers', response);
        }
        var player2Socket = getSocketByUserId(player2_id);
        if (player2Socket) {
            player2Socket.emit('redraw checkers', response);
        }
    });
    socket.on('disconnect', function () {
        if (game_id && game_servers[game_id] && game_servers[game_id].status_id == 2) {
            var player1_id = game_servers[game_id].player1.id;
            var player2_id = game_servers[game_id].player2.id;
            var opponentSocket = getSocketByUserId((player1_id == user_id ? player2_id : player1_id));
            if (opponentSocket) {
                opponentSocket.emit('opponent disconnected');
            }
        }
        if (game_id && lig_game_servers[game_id] && lig_game_servers[game_id].status_id == 2) {
            var player1_id = lig_game_servers[game_id].player1.id;
            var player2_id = lig_game_servers[game_id].player2.id;
            var opponentSocket = getSocketByUserId((player1_id == user_id ? player2_id : player1_id));
            if (opponentSocket) {
                opponentSocket.emit('opponent disconnected');
            }
        }
        if (user_id && users[user_id]) {
            delete users[user_id];
            io.to('games_index').emit('users count', users);
        }
        var rooms = io.sockets.adapter.sids[socket.id];
        if (rooms) {
            for (var room in rooms) {
                socket.leave(room);
            }
        }
    });
    function login(username, password, room, call_back) {
        if (user_id) {
            socket.emit('message', 'close tabs', {user_id: user_id});
            socket.disconnect();
            return;
        }

        Q('SELECT id,fullname,credit FROM users WHERE username=? AND password_hash=? LIMIT 1', [username, password], function (err, res) {

            if (!res || !res[0]) {
                socket.emit('message', 'wrong username or password', {username: username, password: password});
                socket.disconnect();
                return;
            }

            var row = res[0];
            row.id = row.id.toString();
            user_id = row.id;

            if (room == 'admin_site_index') {
                socket.join('games_index');
                socket.emit('games count', game_servers);
            }
            else {
                users[user_id] = row;
                users[user_id].socket_id = socket.id;
            }

            socket.join(room);
            io.to('games_index').emit('users count', users);
            call_back();
        });
    }
});
function finishTurn(gid) {
    var isEndGame = game_servers[gid].finishTurn();
    if (isEndGame) {
        if (myIntervals[gid]) {
            clearInterval(myIntervals[gid]);
        }
        if (myTimeouts[gid]) {
            clearTimeout(myTimeouts[gid]);
        }
        if (mydtIntervals[gid]) {
            clearInterval(mydtIntervals[gid]);
        }
        var board_id = game_servers[gid].board_id;
        var winner_id = game_servers[gid].winner.id;
        var player1_id = game_servers[gid].player1.id;
        var player1_fullname = game_servers[gid].player1.fullname;
        var player2_id = game_servers[gid].player2.id;
        var player2_fullname = game_servers[gid].player2.fullname;
        var type_id = game_servers[gid].type_id;
        var type_title = game_servers[gid].type_title;
        var amount = game_servers[gid].amount;
        var total_amount = game_servers[gid].total_amount;
        finishBoard(winner_id, board_id);
        if (isMarss(game_servers[gid])) {
            setBoard(gid, function (board_id) {
                finishBoard(winner_id, board_id);
                getWins(gid, player1_id, player2_id, function (player1_wins, player2_wins) {
                    delete game_servers[gid];
                    io.emit('games list', gamesList());
                    io.to('admin_site_index').emit('games count', game_servers);
                    var final_wins = (type_id == 1 ? 1 : (type_id == 2 ? 3 : (type_id == 3 ? 7 : 0)));
                    if (player1_wins >= final_wins || player2_wins >= final_wins) {
                        var final_winner_id = player1_wins >= final_wins ? player1_id : player2_id;
                        var final_loser_id = player1_wins >= final_wins ? player2_id : player1_id;
                        var final_winner_type = player1_wins >= final_wins ? 0 : 1;
                        finishGame(gid, final_winner_id, final_loser_id);
                        deposit(total_amount, final_winner_id);
                        var player1_socket = getSocketByUserId(player1_id);
                        if (player1_socket) {
                            player1_socket.emit('finish game', final_winner_type);
                        }
                        var player2_socket = getSocketByUserId(player2_id);
                        if (player2_socket) {
                            player2_socket.emit('finish game', final_winner_type);
                        }
                    }
                    else {
                        setBoard(gid, function (board_id) {
                            var player1 = new game_server.Player(player1_id, player1_fullname);
                            var player2 = new game_server.Player(player2_id, player2_fullname);
                            var mygameserver = new game_server.Game();
                            mygameserver.setPlayer(1, player1);
                            mygameserver.setPlayer(2, player2);
                            mygameserver.id = gid;
                            mygameserver.amount = amount;
                            mygameserver.total_amount = total_amount;
                            mygameserver.type_id = type_id;
                            mygameserver.type_title = type_title;
                            mygameserver.status_id = 2;
                            mygameserver.board_id = board_id;
                            mygameserver.start();
                            setDices(mygameserver.board_id, mygameserver.currentPlayer.id, mygameserver.diceRoller.firstValue, mygameserver.diceRoller.secondValue, function (dice_id) {
                                mygameserver.dice_id = dice_id;
                                var player1_socket = getSocketByUserId(mygameserver.player1.id);
                                if (player1_socket) {
                                    player1_socket.emit('pre play', gid);
                                }
                                var player2_socket = getSocketByUserId(mygameserver.player2.id);
                                if (player2_socket) {
                                    player2_socket.emit('pre play', gid);
                                }
                                game_servers[gid] = mygameserver;
                                game_servers[gid].canMoveChecker = true;
                                setTimer(gid);
                                io.emit('games list', gamesList());
                                io.to('admin_site_index').emit('games count', game_servers);
                            });
                        });
                    }
                });
            });
        }
        else {
            getWins(gid, player1_id, player2_id, function (player1_wins, player2_wins) {
                delete game_servers[gid];
                io.emit('games list', gamesList());
                io.to('admin_site_index').emit('games count', game_servers);
                var final_wins = (type_id == 1 ? 1 : (type_id == 2 ? 3 : (type_id == 3 ? 7 : 0)));
                if (player1_wins >= final_wins || player2_wins >= final_wins) {
                    var final_winner_id = player1_wins >= final_wins ? player1_id : player2_id;
                    var final_loser_id = player1_wins >= final_wins ? player2_id : player1_id;
                    var final_winner_type = player1_wins >= final_wins ? 0 : 1;
                    finishGame(gid, final_winner_id, final_loser_id);
                    deposit(total_amount, final_winner_id);
                    var player1_socket = getSocketByUserId(player1_id);
                    if (player1_socket) {
                        player1_socket.emit('finish game', final_winner_type);
                    }
                    var player2_socket = getSocketByUserId(player2_id);
                    if (player2_socket) {
                        player2_socket.emit('finish game', final_winner_type);
                    }
                }
                else {
                    setBoard(gid, function (board_id) {
                        var player1 = new game_server.Player(player1_id, player1_fullname);
                        var player2 = new game_server.Player(player2_id, player2_fullname);
                        var mygameserver = new game_server.Game();
                        mygameserver.setPlayer(1, player1);
                        mygameserver.setPlayer(2, player2);
                        mygameserver.id = gid;
                        mygameserver.amount = amount;
                        mygameserver.total_amount = total_amount;
                        mygameserver.type_id = type_id;
                        mygameserver.type_title = type_title;
                        mygameserver.status_id = 2;
                        mygameserver.board_id = board_id;
                        mygameserver.start();
                        setDices(mygameserver.board_id, mygameserver.currentPlayer.id, mygameserver.diceRoller.firstValue, mygameserver.diceRoller.secondValue, function (dice_id) {
                            mygameserver.dice_id = dice_id;
                            var player1_socket = getSocketByUserId(mygameserver.player1.id);
                            if (player1_socket) {
                                player1_socket.emit('pre play', gid);
                            }
                            var player2_socket = getSocketByUserId(mygameserver.player2.id);
                            if (player2_socket) {
                                player2_socket.emit('pre play', gid);
                            }
                            game_servers[gid] = mygameserver;
                            game_servers[gid].canMoveChecker = true;
                            setTimer(gid);
                            io.emit('games list', gamesList());
                            io.to('admin_site_index').emit('games count', game_servers);
                        });
                    });
                }
            });
        }
    }
    else {
        var board_id = game_servers[gid].board_id;
        var player_id = game_servers[gid].currentPlayer.id;
        var firstValue = game_servers[gid].diceRoller.firstValue;
        var secondValue = game_servers[gid].diceRoller.secondValue;
        setDices(board_id, player_id, firstValue, secondValue, function (dice_id) {
            game_servers[gid].dice_id = dice_id;
            var availableMoves = redraw(game_servers[gid]);
            if (availableMoves.length) {
                game_servers[gid].canMoveChecker = true;
                setTimer(gid);
            }
            else {
                setTimeout(function () {
                    finishTurn(gid);
                }, 2000);
            }
        });
    }
}
function RobotDoMoves(gid) {

    var dice_id = game_servers[gid].dice_id;
    var player1_id = game_servers[gid].player1.id;
    var player2_id = game_servers[gid].player2.id;
    var current_player_id = game_servers[gid].currentPlayer.id;
    var currentPlayerType = current_player_id == player1_id ? 0 : 1;

    var availableMoves = game_servers[gid].availableMoves();
    if (availableMoves.length) {

        var source = availableMoves[0].from;
        var target = availableMoves[0].to;

        var distance = game_servers[gid].moveChecker(source, target);
        setPlay(dice_id, source, target, distance);

        var points = getPoints(game_servers[gid]);
        var response = {currentPlayer: currentPlayerType, availableMoves: [], points: points};

        var player1Socket = getSocketByUserId(player1_id);
        if (player1Socket) {
            player1Socket.emit('redraw checkers', response);
        }
        var player2Socket = getSocketByUserId(player2_id);
        if (player2Socket) {
            player2Socket.emit('redraw checkers', response);
        }

        if (game_servers[gid].diceRoller.valuesCount()) {
            setTimeout(function () {
                RobotDoMoves(gid);
            }, 2000);
        }
        else {
            setTimeout(function () {
                finishTurn(gid);
            }, 2000);
        }
    }
    else {
        finishTurn(gid);
    }
}
function dttimer(gid, currentTime) {
    var player_1_id = game_servers[gid].player1.id;
    var player_2_id = game_servers[gid].player2.id;
    var current_player_id = game_servers[gid].currentPlayer.id;
    var current_player_type = current_player_id.toString() === game_servers[gid].player1.id.toString() ? '0' : '1';
    if (0 < dts[gid][current_player_type]) {
        mydtIntervals[gid] = setInterval(function () {

            var current_player_socket = getSocketByUserId(current_player_id);
            if (current_player_socket) {
                clearInterval(mydtIntervals[gid]);
                setTimer(gid, currentTime);
                return;
            }

            var player_1_socket = getSocketByUserId(player_1_id);
            if (player_1_socket) {
                player_1_socket.emit('show disconnect timer', dts[gid][current_player_type] / 1000, parseInt(current_player_type));
            }

            var player_2_socket = getSocketByUserId(player_2_id);
            if (player_2_socket) {
                player_2_socket.emit('show disconnect timer', dts[gid][current_player_type] / 1000, parseInt(current_player_type));
            }

            if (0 < dts[gid][current_player_type]) {
                dts[gid][current_player_type] -= 1000;
            }
            else {
                clearInterval(mydtIntervals[gid]);
                RobotDoMoves(gid);
            }
        }, 1000);
    }
    else {
        RobotDoMoves(gid);
    }
}
function setTimer(gid, in_ct) {
    if (!game_servers[gid]) {
        if (myIntervals[gid]) {
            clearInterval(myIntervals[gid]);
        }
        if (mydtIntervals[gid]) {
            clearInterval(mydtIntervals[gid]);
        }
        if (myTimeouts[gid]) {
            clearTimeout(myTimeouts[gid]);
        }
        return;
    }
    var currentTime = in_ct ? in_ct : ct;
    var endTime = in_ct ? in_ct + 2000 : et;
    if (!dts[gid]) {
        dts[gid] = {'0': dt, '1': dt};
    }

    var player1_id = game_servers[gid].player1.id;
    var player2_id = game_servers[gid].player2.id;
    var current_player_id = game_servers[gid].currentPlayer.id;
    var current_player_type = game_servers[gid].currentPlayer.id == game_servers[gid].player1.id ? 0 : 1;
    var current_player_socket = getSocketByUserId(current_player_id);

    if (current_player_socket) {
        var i = 1;
        myIntervals[gid] = setInterval(function () {

            if (!game_servers[gid]) {
                if (myIntervals[gid]) {
                    clearInterval(myIntervals[gid]);
                }
                if (mydtIntervals[gid]) {
                    clearInterval(mydtIntervals[gid]);
                }
                if (myTimeouts[gid]) {
                    clearTimeout(myTimeouts[gid]);
                }
                return;
            }

            var current_player_socket = getSocketByUserId(current_player_id);
            if (!current_player_socket) {
                clearInterval(myIntervals[gid]);
                clearTimeout(myTimeouts[gid]);
                dttimer(gid, currentTime);
                return;
            }

            var player1_socket = getSocketByUserId(player1_id);
            if (player1_socket) {
                player1_socket.emit('show timer', currentTime, current_player_type);
            }

            var player2_socket = getSocketByUserId(player2_id);
            if (player2_socket) {
                player2_socket.emit('show timer', currentTime, current_player_type);
            }

            var availableMoves = game_servers[gid].availableMoves();
            if (availableMoves.length) {
                i = 1;
            }
            else {
                if (i == 3) {
                    clearTimeout(myTimeouts[gid]);
                    clearInterval(myIntervals[gid]);
                    finishTurn(gid);
                    return;
                }
                i++;
            }
            if (currentTime > 0) {
                currentTime -= 1000;
            }
            else {
                clearInterval(myIntervals[gid]);
            }
        }, 1000);
        myTimeouts[gid] = setTimeout(function () {
            if (!game_servers[gid]) {
                if (myIntervals[gid]) {
                    clearInterval(myIntervals[gid]);
                }
                if (mydtIntervals[gid]) {
                    clearInterval(mydtIntervals[gid]);
                }
                if (myTimeouts[gid]) {
                    clearTimeout(myTimeouts[gid]);
                }
                return;
            }
            game_servers[gid].canMoveChecker = false;
            if (game_servers[gid].diceRoller.valuesCount()) {
                var current_player_id = game_servers[gid].currentPlayer.id;
                var current_player_socket = getSocketByUserId(current_player_id);
                if (current_player_socket) {
                    current_player_socket.emit('dont move');
                }
                RobotDoMoves(gid);
            }
            else {
                finishTurn(gid);
            }
        }, endTime);
    }
    else {
        dttimer(gid);
    }
}
function finishBoard(winner_id, board_id) {
    var status_id = 2;
    var datetime = getDateTime();
    Q('UPDATE games_boards SET status_id=?, winner_id=?, finished_at=? WHERE id=?', [
        status_id, winner_id, datetime, board_id
    ]);
}
function startGame(gid, player2_id) {
    var datetime = getDateTime();
    Q('UPDATE games SET status_id=2, player_2=?, started_at=? WHERE id=?', [
        player2_id, datetime, gid
    ]);
}
function finishGame(gid, winner_id, loser_id) {
    var status_id = 3;
    var datetime = getDateTime();
    Q('UPDATE games SET status_id=?, winner_id=?, loser_id=?, finished_at=? WHERE id=?', [
        status_id, winner_id, loser_id, datetime, gid
    ]);
}
function reduceCredit(amount, user_id) {
    Q('UPDATE users SET credit=? WHERE id=?', [
        amount, user_id
    ]);
}
function isGameIdValid(gid, user_id) {
    if (user_id) {
        if (typeof gid == 'string' && isNumber(gid)) {
            if (game_servers[gid] && game_servers[gid].status_id == 2) {
                if (user_id == game_servers[gid].player1.id || user_id == game_servers[gid].player2.id) {
                    return true;
                }
            }
        }
    }
    return false;
}
function isGameIdValidToJoin(gid, user_id) {
    if (typeof gid == 'string' && isNumber(gid)) {
        if (game_servers[gid] && game_servers[gid].status_id == 1) {
            if (user_id && user_id !== game_servers[gid].player1.id) {
                return true;
            }
        }
    }
    return false;
}
function isGameIdValidToCancel(gid, user_id) {
    if (typeof gid == 'string' && isNumber(gid)) {
        if (game_servers[gid] && game_servers[gid].status_id == 1) {
            if (user_id && user_id == game_servers[gid].player1.id) {
                return true;
            }
        }
    }
    return false;
}
function setPlay(dice_id, source, target, distance) {
    var datetime = getDateTime();
    Q('INSERT INTO games_boards_plays (`dice_id`, `from`, `to`, `distance`, `datetime`) VALUES (?, ?, ?, ?, ?)', [
        dice_id, source, target, distance, datetime
    ]);
}
function gamesList() {
    var rows = [], keys = Object.keys(game_servers), len = keys.length;
    keys.sort(function (a, b) {
        return b - a;
    });
    for (var i = 0; i < len; i++) {
        var data = game_servers[keys[i]].getData();
        var player1_socket = getSocketByUserId(data.player1.id);
        if (player1_socket) {
            rows[rows.length] = data;
        }
    }
    return rows;
}
function setBoard(gid, call_back) {
    var datetime = getDateTime();
    Q('INSERT INTO games_boards (game_id, started_at, finished_at, status_id) VALUES (?, ?, ?, 1)', [
        gid, datetime, datetime
    ], function (err, res) {
        call_back(res.insertId);
    });
}
function getWins(gid, player1, player2, call_back) {
    Q('SELECT get_count(?, ?) as player1, get_count(?, ?) as player2', [
        gid, player1, gid, player2
    ], function (err, res) {
        call_back(res[0].player1, res[0].player2);
    });
}
function setDices(board_id, player_id, firstValue, secondValue, call_back) {
    var datetime = getDateTime();
    Q('INSERT INTO games_boards_dices (board_id, player_id, roll_1, roll_2, datetime) VALUES (?, ?, ?, ?, ?)', [
        board_id, player_id, firstValue, secondValue, datetime
    ], function (err, res) {
        call_back(res.insertId);
    });
}
function getDices(board_id, call_back) {
    Q('SELECT count(*) as dices_count FROM games_boards_dices WHERE board_id=?', [
        board_id
    ], function (err, res) {
        call_back(res[0].dices_count);
    });
}
function handleDisconnect(type) {
    console.log('DB Connection ' + (type !== 1 ? 're' : '') + 'started at: ' + getDateTime());
    con = mysql.createConnection(db_config);
    con.connect(function (err) {
        if (err) {
            setTimeout(function () {
                handleDisconnect(2);
            }, 2000);
            return;
        }
    });
    con.on('error', function (err) {
        if (err.code == 'PROTOCOL_CONNECTION_LOST') {
            setTimeout(function () {
                handleDisconnect(3);
            }, 2000);
        }
        else {
            throw err;
        }
    });
}
function ligs() {
    var datetime = getDateTime();
    var sql = "SELECT id FROM ligs WHERE status_id=2 AND concat(start_date, ' ', start_time) < ?";
    Q(sql, [datetime], function (err, res) {
        if (res && res.length) {
            Q("UPDATE ligs SET status_id=3 WHERE status_id=2 AND concat(start_date, ' ', start_time) < ?", [datetime]);
            var ids = '';
            for (var item in res) {
                var id = res[item].id;
                ids += (ids ? ',' : '') + id;
            }
            sql = '';
            sql += 'SELECT m2.id lig_id, m1.id game_id, m1.player_1 player1id, m3.fullname player1fullname, m1.player_2 player2id, m4.fullname player2fullname, m2.type_id, m5.title type_title, m2.amount, m2.total_amount ';
            sql += 'FROM ligs_games m1 ';
            sql += 'INNER JOIN ligs m2 ON m2.id=m1.lig_id ';
            sql += 'INNER JOIN users m3 ON m3.id=m1.player_1 ';
            sql += 'INNER JOIN users m4 ON m4.id=m1.player_2 ';
            sql += 'INNER JOIN ligs_types m5 ON m5.id=m2.type_id ';
            sql += 'WHERE m1.status_id=2 AND m1.player_1 IS NOT NULL AND m1.player_2 IS NOT NULL AND m1.lig_id IN (' + ids + ') ';
            Q(sql, [], function (err2, res2) {
                Q('UPDATE ligs_games SET status_id=3, started_at=? WHERE status_id=2 AND player_1 IS NOT NULL AND player_2 IS NOT NULL AND lig_id IN (' + ids + ')', [datetime]);
                makeGames(res2);
            });
        }
    });
    setTimeout(ligs, 1000 * 60);
}
function ligSetBoard(game_id, cb) {
    var datetime = getDateTime();
    Q('INSERT INTO ligs_games_boards (game_id, started_at, status_id) VALUES (?, ?, 1)', [game_id, datetime], function (err, res) {
        cb(res.insertId);
    });
}
function ligSetDices(board_id, player_id, firstValue, secondValue, call_back) {
    var datetime = getDateTime();
    Q('INSERT INTO ligs_games_boards_dices (board_id, player_id, roll_1, roll_2, datetime) VALUES (?, ?, ?, ?, ?)', [
        board_id, player_id, firstValue, secondValue, datetime
    ], function (err, res) {
        call_back(res.insertId);
    });
}
function ligDtTimer(gid, currentTime) {
    var player_1_id = lig_game_servers[gid].player1.id;
    var player_2_id = lig_game_servers[gid].player2.id;
    var current_player_id = lig_game_servers[gid].currentPlayer.id;
    var current_player_type = current_player_id.toString() === lig_game_servers[gid].player1.id.toString() ? '0' : '1';
    if (0 < ligDts[gid][current_player_type]) {
        mydtIntervals[gid] = setInterval(function () {

            var current_player_socket = getSocketByUserId(current_player_id);
            if (current_player_socket) {
                clearInterval(mydtIntervals[gid]);
                ligSetTimer(gid, currentTime);
                return;
            }

            var player_1_socket = getSocketByUserId(player_1_id);
            if (player_1_socket) {
                player_1_socket.emit('show disconnect timer', ligDts[gid][current_player_type] / 1000, parseInt(current_player_type));
            }

            var player_2_socket = getSocketByUserId(player_2_id);
            if (player_2_socket) {
                player_2_socket.emit('show disconnect timer', ligDts[gid][current_player_type] / 1000, parseInt(current_player_type));
            }

            if (0 < ligDts[gid][current_player_type]) {
                ligDts[gid][current_player_type] -= 1000;
            }
            else {
                clearInterval(mydtIntervals[gid]);
                var availableMoves = lig_game_servers[gid].availableMoves();
                ligRobotDoMoves(gid, availableMoves);
            }
        }, 1000);
    }
    else {
        var availableMoves = lig_game_servers[gid].availableMoves();
        ligRobotDoMoves(gid, availableMoves);
    }
}
function ligSetTimer(gid, in_ct) {
    if (!lig_game_servers[gid]) {
        if (ligMyIntervals[gid]) {
            clearInterval(ligMyIntervals[gid]);
        }
        if (ligMydtIntervals[gid]) {
            clearInterval(ligMydtIntervals[gid]);
        }
        if (ligMyTimeouts[gid]) {
            clearTimeout(ligMyTimeouts[gid]);
        }
        return;
    }
    var currentTime = in_ct ? in_ct : ct;
    var endTime = in_ct ? in_ct + 2000 : et;
    if (!ligDts[gid]) {
        ligDts[gid] = {'0': dt, '1': dt};
    }

    var mygameserver = lig_game_servers[gid];
    var player1_id = mygameserver.player1.id;
    var player2_id = mygameserver.player2.id;
    var currentPlayer_id = mygameserver.currentPlayer.id;
    var current_player_type = currentPlayer_id == player1_id ? 0 : 1;
    var current_player_socket = getSocketByUserId(currentPlayer_id);
    if (current_player_socket) {
        var i = 1;
        ligMyIntervals[gid] = setInterval(function () {
            if (!lig_game_servers[gid]) {
                if (ligMyIntervals[gid]) {
                    clearInterval(ligMyIntervals[gid]);
                }
                if (ligMyTimeouts[gid]) {
                    clearTimeout(ligMyTimeouts[gid]);
                }
                if (ligMydtIntervals[gid]) {
                    clearInterval(ligMydtIntervals[gid]);
                }
                return;
            }

            var current_player_socket = getSocketByUserId(currentPlayer_id);
            if (!current_player_socket) {
                if (ligMyIntervals[gid]) {
                    clearInterval(ligMyIntervals[gid]);
                }
                if (ligMyTimeouts[gid]) {
                    clearTimeout(ligMyTimeouts[gid]);
                }
                ligDtTimer(gid, currentTime);
                return;
            }
            var player1_socket = getSocketByUserId(player1_id);
            if (player1_socket) {
                player1_socket.emit('show timer', currentTime, current_player_type);
            }

            var player2_socket = getSocketByUserId(player2_id);
            if (player2_socket) {
                player2_socket.emit('show timer', currentTime, current_player_type);
            }

            var availableMoves = lig_game_servers[gid].availableMoves();
            if (availableMoves.length) {
                i = 1;
            }
            else {
                if (i == 3) {
                    if (ligMyIntervals[gid]) {
                        clearInterval(ligMyIntervals[gid]);
                    }
                    if (ligMyTimeouts[gid]) {
                        clearTimeout(ligMyTimeouts[gid]);
                    }
                    ligFinishTurn(gid);
                    return;
                }
                i++;
            }
            if (currentTime > 0) {
                currentTime -= 1000;
            }
            else {
                if (ligMyIntervals[gid]) {
                    clearInterval(ligMyIntervals[gid]);
                }
            }
        }, 1000);
        ligMyTimeouts[gid] = setTimeout(function () {
            if (!lig_game_servers[gid]) {
                if (ligMyIntervals[gid]) {
                    clearInterval(ligMyIntervals[gid]);
                }
                if (ligMydtIntervals[gid]) {
                    clearInterval(ligMydtIntervals[gid]);
                }
                if (ligMyTimeouts[gid]) {
                    clearTimeout(ligMyTimeouts[gid]);
                }
                return;
            }
            lig_game_servers[gid].canMoveChecker = false;
            var availableMoves = lig_game_servers[gid].availableMoves();
            if (availableMoves.length) {
                ligRobotDoMoves(gid, availableMoves);
            }
            else {
                ligFinishTurn(gid);
            }
        }, endTime);
    }
    else {
        ligDtTimer(gid);
    }
}
function ligFinishTurn(gid) {
    var isEndGame = lig_game_servers[gid].finishTurn();
    if (isEndGame) {
        var lig_id = lig_game_servers[gid].lig_id;
        var board_id = lig_game_servers[gid].board_id;
        var winner_id = lig_game_servers[gid].winner.id;
        var player1_id = lig_game_servers[gid].player1.id;
        var player1_fullname = lig_game_servers[gid].player1.fullname;
        var player2_id = lig_game_servers[gid].player2.id;
        var player2_fullname = lig_game_servers[gid].player2.fullname;
        var type_id = lig_game_servers[gid].type_id;
        var type_title = lig_game_servers[gid].type_title;
        var amount = lig_game_servers[gid].amount;
        var total_amount = lig_game_servers[gid].total_amount;
        ligFinishBoard(winner_id, board_id);
        if (isMarss(lig_game_servers[gid])) {
            ligSetBoard(gid, function (board_id) {
                ligFinishBoard(winner_id, board_id);
            });
        }
        ligGetWins(gid, player1_id, player2_id, function (player1_wins, player2_wins) {
            delete lig_game_servers[gid];
            var final_wins = (type_id == 1 ? 1 : (type_id == 2 ? 3 : (type_id == 3 ? 7 : 0)));
            if (player1_wins >= final_wins || player2_wins >= final_wins) {
                var final_winner_id = player1_wins >= final_wins ? player1_id : player2_id;
                var final_loser_id = player1_wins >= final_wins ? player2_id : player1_id;
                ligFinishGame(lig_id, gid, final_winner_id, final_loser_id);
                var winner_socket = getSocketByUserId(final_winner_id);
                if (winner_socket) {
                    winner_socket.emit('go', 'ligs view');
                }
                var loser_socket = getSocketByUserId(final_loser_id);
                if (loser_socket) {
                    loser_socket.emit('go', 'ligs view');
                }
            }
            else {
                ligSetBoard(gid, function (board_id) {
                    var mygameserver = new game_server.Game();
                    mygameserver.player1 = new game_server.Player(player1_id, player1_fullname);
                    mygameserver.player2 = new game_server.Player(player2_id, player2_fullname);
                    mygameserver.lig_id = lig_id;
                    mygameserver.id = gid;
                    mygameserver.amount = amount;
                    mygameserver.total_amount = total_amount;
                    mygameserver.type_id = type_id;
                    mygameserver.type_title = type_title;
                    mygameserver.status_id = 2;
                    mygameserver.board_id = board_id;
                    mygameserver.start();
                    ligSetDices(mygameserver.board_id, mygameserver.currentPlayer.id, mygameserver.diceRoller.firstValue, mygameserver.diceRoller.secondValue, function (dice_id) {
                        mygameserver.dice_id = dice_id;
                        lig_game_servers[gid] = mygameserver;
                        lig_game_servers[gid].canMoveChecker = true;
                        var player1_socket = getSocketByUserId(mygameserver.player1.id);
                        if (player1_socket) {
                            player1_socket.emit('go', 'ligs play');
                        }
                        var player2_socket = getSocketByUserId(mygameserver.player2.id);
                        if (player2_socket) {
                            player1_socket.emit('go', 'ligs play');
                        }
                        ligSetTimer(gid);
                    });
                });
            }
        });
    }
    else {
        var board_id = lig_game_servers[gid].board_id;
        var player_id = lig_game_servers[gid].currentPlayer.id;
        var firstValue = lig_game_servers[gid].diceRoller.firstValue;
        var secondValue = lig_game_servers[gid].diceRoller.secondValue;
        ligSetDices(board_id, player_id, firstValue, secondValue, function (dice_id) {
            lig_game_servers[gid].dice_id = dice_id;
            var availableMoves = redraw(lig_game_servers[gid]);
            if (availableMoves.length) {
                var currentPlayerSocket = getSocketByUserId(player_id);
                if (currentPlayerSocket) {
                    lig_game_servers[gid].canMoveChecker = true;
                    ligSetTimer(gid);
                }
                else {
                    setTimeout(function () {
                        ligRobotDoMoves(gid, availableMoves);
                    }, 2000);
                }
            }
            else {
                setTimeout(function () {
                    ligFinishTurn(gid);
                }, 2000);
            }
        });
    }
}
function ligRobotDoMoves(gid, availableMoves) {
    var dice_id = lig_game_servers[gid].dice_id;
    var player1_id = lig_game_servers[gid].player1.id;
    var player2_id = lig_game_servers[gid].player2.id;
    var current_player_id = lig_game_servers[gid].currentPlayer.id;
    var currentPlayerType = current_player_id == player1_id ? 0 : 1;
    var source = availableMoves[0].from;
    var target = availableMoves[0].to;
    var distance = lig_game_servers[gid].moveChecker(source, target);
    ligSetPlay(dice_id, source, target, distance);
    var points = getPoints(lig_game_servers[gid]);
    var response = {currentPlayer: currentPlayerType, availableMoves: [], points: points};
    var player1Socket = getSocketByUserId(player1_id);
    if (player1Socket) {
        player1Socket.emit('redraw checkers', response);
    }
    var player2Socket = getSocketByUserId(player2_id);
    if (player2Socket) {
        player2Socket.emit('redraw checkers', response);
    }
    var availableMoves2 = lig_game_servers[gid].availableMoves();
    if (availableMoves2.length) {
        setTimeout(function () {
            ligRobotDoMoves(gid, availableMoves2);
        }, 2000);
    }
    else {
        setTimeout(function () {
            ligFinishTurn(gid);
        }, 2000);
    }
}
function ligSetPlay(dice_id, source, target, distance) {
    var datetime = getDateTime();
    Q('INSERT INTO ligs_games_boards_plays (`dice_id`, `from`, `to`, `distance`, `datetime`) VALUES (?, ?, ?, ?, ?)', [
        dice_id, source, target, distance, datetime
    ]);
}
function ligFinishBoard(winner_id, board_id) {
    var finished_at = getDateTime();
    Q('UPDATE ligs_games_boards SET status_id=2, winner_id=?, finished_at=? WHERE id=?', [
        winner_id, finished_at, board_id
    ]);
}
function ligGetWins(gid, player1, player2, call_back) {
    Q('SELECT lig_get_count(?, ?) as player1, lig_get_count(?, ?) as player2', [
        gid, player1, gid, player2
    ], function (err, res) {
        call_back(res[0].player1, res[0].player2);
    });
}
function ligFinishGame(lig_id, game_id, winner_id, loser_id) {
    var datetime = getDateTime();
    Q('UPDATE ligs_games SET status_id=4, winner_id=?, loser_id=?, finished_at=? WHERE id=?', [winner_id, loser_id, datetime, game_id]);
    Q('SELECT * FROM ligs_games WHERE lig_id=? AND status_id=1 ORDER BY id ASC LIMIT 1', [lig_id], function (err, res) {
        if (res && res[0]) {
            if (!res[0].player_1) {
                Q('UPDATE ligs_games SET player_1=? WHERE id=?', [winner_id, res[0].id]);
            }
            else {
                Q('UPDATE ligs_games SET player_2=?, status_id=2 WHERE id=?', [winner_id, res[0].id]);
                var sql = '';
                sql += 'SELECT m2.id lig_id, m1.id game_id, m1.player_1 player1id, m3.fullname player1fullname, m1.player_2 player2id, m4.fullname player2fullname, m2.type_id, m5.title type_title, m2.amount, m2.total_amount ';
                sql += 'FROM ligs_games m1 ';
                sql += 'INNER JOIN ligs m2 ON m2.id=m1.lig_id ';
                sql += 'INNER JOIN users m3 ON m3.id=m1.player_1 ';
                sql += 'INNER JOIN users m4 ON m4.id=m1.player_2 ';
                sql += 'INNER JOIN ligs_types m5 ON m5.id=m2.type_id ';
                sql += 'WHERE m1.id=?';
                Q(sql, [res[0].id], function (err, res) {
                    t(res[0]);
                });
            }
        }
        else {
            ligFinish(lig_id, winner_id);
        }
    });
}
function getLig(lig_id, cb) {
    Q('SELECT * FROM ligs WHERE id=?', [lig_id], function (err, res) {
        cb(res[0]);
    });
}
function ligFinish(lig_id, winner_id) {
    getLig(lig_id, function (lig) {
        deposit(lig.total_amount, winner_id);
        Q('UPDATE ligs SET status_id=? WHERE id=?', [4, lig_id]);
        //res.affectedrows
    });
}
function ligDoMove(socket, data, user_id) {
    var gid = data.gid;
    var source = data.source;
    var target = data.target;
    if (!isGameIdValidForLig(gid, user_id)) {
        return;
    }
    if (lig_game_servers[gid].currentPlayer.id == user_id && lig_game_servers[gid].canMoveChecker) {
        var dice_id = lig_game_servers[gid].dice_id;
        var player1_id = lig_game_servers[gid].player1.id;
        var player2_id = lig_game_servers[gid].player2.id;
        var current_player_id = lig_game_servers[gid].currentPlayer.id;
        var currentPlayerType = current_player_id == player1_id ? 0 : 1;
        if (lig_game_servers[gid].canMove(source, target)) {
            var distance = lig_game_servers[gid].moveChecker(source, target);
            ligSetPlay(dice_id, source, target, distance);
            var availableMoves = lig_game_servers[gid].availableMoves();
            var points = getPoints(lig_game_servers[gid]);
            var response = {currentPlayer: currentPlayerType, availableMoves: availableMoves, points: points};
            var player1Socket = getSocketByUserId(player1_id);
            if (player1Socket) {
                player1Socket.emit('redraw checkers', response);
            }
            var player2Socket = getSocketByUserId(player2_id);
            if (player2Socket) {
                player2Socket.emit('redraw checkers', response);
            }
            return;
        }
        var points = getPoints(lig_game_servers[gid]);
        var availableMoves = lig_game_servers[gid].availableMoves();
        var response = {currentPlayer: currentPlayerType, points: points, availableMoves: availableMoves};
        socket.emit('redraw checkers', response);
    }
}
function Q(sql, params, call_back) {
    con.query(sql, params, function (err, res) {
        if (typeof call_back == 'function') {
            call_back(err, res);
        }
    });
}
function getDateTime() {
    var now = new Date;
    var Y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var H = now.getHours();
    var i = now.getMinutes();
    var s = now.getSeconds();
    return Y + '-' + (m < 10 ? '0' : '') + m + '-' + (d < 10 ? '0' : '') + d + ' ' + (H < 10 ? '0' : '') + H + ':' + (i < 10 ? '0' : '') + i + ':' + (s < 10 ? '0' : '') + s;
}
function getSocketByUserId(user_id) {
    if (!user_id || !users[user_id]) {
        return false;
    }
    var user = users[user_id];
    return io.sockets.connected[user.socket_id];
}
function getPoints(game) {
    var p = [];
    for (var i = 1; i < 25; i++) {
        var point = game.getPoint(i);
        var checkers = point.checkers;
        var o = [];
        for (var j = 0; j < checkers.length; j++) {
            var checker = checkers[j];
            if (parseInt(checker.player.id) == parseInt(game.player1.id)) {
                o[j] = {player: 0};
            }
            else {
                o[j] = {player: 1};
            }
        }
        p[i] = {checkers: o};
    }
    var z1 = game.player1Home.checkersCount();
    var c1 = [];
    for (var x = 0; x < z1; x++) {
        c1[x] = {player: 0};
    }
    p[25] = {checkers: c1};
    var z2 = game.player1Graveyard.checkersCount();
    var c2 = [];
    for (var x = 0; x < z2; x++) {
        c2[x] = {player: 0};
    }
    p[26] = {checkers: c2};
    var z3 = game.player2Home.checkersCount();
    var c3 = [];
    for (var x = 0; x < z3; x++) {
        c3[x] = {player: 1};
    }
    p[27] = {checkers: c3};
    var z4 = game.player2Graveyard.checkersCount();
    var c4 = [];
    for (var x = 0; x < z4; x++) {
        c4[x] = {player: 1};
    }
    p[28] = {checkers: c4};
    return p;
}
function redraw(mygameserver) {
    var availableMoves = mygameserver.availableMoves();
    var points = getPoints(mygameserver);
    var currentPlayerType = mygameserver.currentPlayer.id == mygameserver.player1.id ? 0 : 1;
    var response = {currentPlayer: currentPlayerType, availableMoves: availableMoves, points: points, diceRoller: mygameserver.diceRoller};
    var player1Socket = getSocketByUserId(mygameserver.player1.id);
    if (player1Socket) {
        player1Socket.emit('redraw checkers', response);
        player1Socket.emit('redraw dices', response);
    }
    var player2Socket = getSocketByUserId(mygameserver.player2.id);
    if (player2Socket) {
        player2Socket.emit('redraw checkers', response);
        player2Socket.emit('redraw dices', response);
    }
    return availableMoves;
}
function isMarss(game) {
    var player1HomeCheckersCount = game.player1Home.checkersCount();
    var player2HomeCheckersCount = game.player2Home.checkersCount();
    if (player1HomeCheckersCount == 15 && player2HomeCheckersCount == 0) {
        return true;
    }
    else if (player2HomeCheckersCount == 15 && player1HomeCheckersCount == 0) {
        return true;
    }
    return false;
}
function makeGames(rows) {
    makeGame(0);
    function makeGame(n) {
        if (!rows[n]) {
            return;
        }
        var row = rows[n];
        var lig_id = row.lig_id.toString();
        var gid = row.game_id.toString();
        var mygameserver = new game_server.Game();
        mygameserver.lig_id = lig_id;
        mygameserver.id = gid;
        mygameserver.type_id = row.type_id;
        mygameserver.type_title = row.type_title;
        mygameserver.amount = row.amount;
        mygameserver.total_amount = row.total_amount;
        mygameserver.player1 = new game_server.Player(row.player1id, row.player1fullname);
        mygameserver.player2 = new game_server.Player(row.player2id, row.player2fullname);
        mygameserver.status_id = 2;
        mygameserver.start();
        ligSetBoard(gid, function (board_id) {
            mygameserver.board_id = board_id;
            var current_player_id = mygameserver.currentPlayer.id;
            var firstValue = mygameserver.diceRoller.firstValue;
            var secondValue = mygameserver.diceRoller.secondValue;
            ligSetDices(board_id, current_player_id, firstValue, secondValue, function (dice_id) {
                mygameserver.dice_id = dice_id;
                mygameserver.canMoveChecker = true;
                lig_game_servers[gid] = mygameserver;
                var player1socket = getSocketByUserId(mygameserver.player1.id);
                if (player1socket) {
                    player1socket.emit('go', 'ligs play');
                }
                var player2socket = getSocketByUserId(mygameserver.player2.id);
                if (player2socket) {
                    player2socket.emit('go', 'ligs play');
                }
                ligSetTimer(gid);
                if (rows[n + 1]) {
                    makeGame(n + 1);
                }
            });
        });
    }
}
function isGameIdValidForLig(gid, user_id) {
    if (user_id) {
        if (typeof gid == 'string' && isNumber(gid) && lig_game_servers[gid]) {
            var game = lig_game_servers[gid];
            if (game.status_id == 2) {
                if (user_id == game.player1.id || user_id == game.player2.id) {
                    return true;
                }
            }
        }
    }
    return false;
}
function isNumber(n) {
    return /^-?[\d.]+(?:e-?\d+)?$/.test(n);
}
function ligPendingPlay(gid) {
    var a, c = 59, d = 60, datetime = getDateTime();
    var game = lig_game_servers[gid];
    var player1id = game.player1.id;
    var player2id = game.player2.id;
    a = setInterval(function () {
        var player1socket = getSocketByUserId(player1id);
        if (player1socket) {
            player1socket.emit('pending play', gid, c);
        }
        var player2socket = getSocketByUserId(player2id);
        if (player2socket) {
            player2socket.emit('pending play', gid, c);
        }
        c = c - 1;
    }, 1000 * 1);
    setTimeout(function () {
        clearInterval(a);
        Q('UPDATE ligs_games SET status_id=3, started_at=? WHERE id=?', [datetime, gid], function () {
            var player1socket = getSocketByUserId(player1id);
            if (player1socket) {
                player1socket.emit('go', 'ligs play');
            }
            var player2socket = getSocketByUserId(player2id);
            if (player2socket) {
                player2socket.emit('go', 'ligs play');
            }
            game.canMoveChecker = true;
            ligSetTimer(gid);
        });
    }, 1000 * d);
}
function t(row) {
    var lig_id = row.lig_id.toString();
    var gid = row.game_id.toString();
    var mygameserver = new game_server.Game();
    mygameserver.lig_id = lig_id;
    mygameserver.id = gid;
    mygameserver.type_id = row.type_id;
    mygameserver.type_title = row.type_title;
    mygameserver.amount = row.amount;
    mygameserver.total_amount = row.total_amount;
    mygameserver.player1 = new game_server.Player(row.player1id, row.player1fullname);
    mygameserver.player2 = new game_server.Player(row.player2id, row.player2fullname);
    mygameserver.status_id = 2;
    mygameserver.start();
    ligSetBoard(gid, function (board_id) {
        mygameserver.board_id = board_id;
        var current_player_id = mygameserver.currentPlayer.id;
        var firstValue = mygameserver.diceRoller.firstValue;
        var secondValue = mygameserver.diceRoller.secondValue;
        ligSetDices(board_id, current_player_id, firstValue, secondValue, function (dice_id) {
            mygameserver.dice_id = dice_id;
            lig_game_servers[gid] = mygameserver;

            var player1socket = getSocketByUserId(mygameserver.player1.id);
            if (player1socket) {
                player1socket.emit('go', 'ligs view');
            }

            var player2socket = getSocketByUserId(mygameserver.player2.id);
            if (player2socket) {
                player2socket.emit('go', 'ligs view');
            }

            ligPendingPlay(gid);
        });
    });
}
function getUser(id, cb) {
    Q('SELECT * FROM users WHERE id=?', [id], function (err, res) {
        cb(res);
    });
}
function deposit(total_amount, winner_id) {
    Q('UPDATE users SET credit = credit + ? WHERE id=?', [total_amount, winner_id]);
}
function settings () {
    Q('SELECT game_timeout, game_disconnect FROM settings',[], function (err, res) {
        dt = res[0].game_disconnect;
        ct = res[0].game_timeout;
        et = ct + 2000;
        setTimeout(settings, 1000);
    });
}