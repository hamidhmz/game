/* global server_url, password, username, game_id, ligs_play_url, ligs_view_url */

var whiteDiceNrs = ["white-one", "white-two", "white-three", "white-four", "white-five", "white-six"];
var brownDiceNrs = ["brown-one", "brown-two", "brown-three", "brown-four", "brown-five", "brown-six"];
var type = -1, opponentType = -1, myName = '', opponentName = '';

$(function () {
    var socket = io(server_url, {query: 'p=ligs_play&i=1&g=1'});
    socket.on('connect', function () {
        $('#connecting').hide();
        socket.emit('ligs_play', username, password, game_id);
    });
    socket.on('connect_error', function () {
        $('#connecting').show();
    });
    socket.on('disconnect', function () {
        $('#connecting').show();
    });
    socket.on('message', function (message, data) {
        alert(message);
    });
    socket.on('go', function (where) {
        if ('ligs play' === where) {
            window.location = ligs_play_url;
        }
        else if ('ligs view' === where) {
            window.location = ligs_view_url;
        }
    });

    // Games Commands
    socket.on("let's play", function (data) {
        // data = {dices_count, wins, names, currentPlayer, type, availableMoves, points, diceRoller, amount}
        type = data.type;
        opponentType = data.type === 0 ? 1 : 0;
        myName = data.names[type];
        opponentName = data.names[opponentType];

        redrawBasics(data.currentPlayer); // show which player shoud play
        redrawCheckers(socket, data); // set checkers to points and events

        if (data.dices_count === 1) {
            showBrownDice(1, data.diceRoller.firstValue);
            showWhiteDice(1, data.diceRoller.secondValue);
            setTimeout(function () {
                redrawDices(data.currentPlayer, data.diceRoller);
            }, 2000);
        }
        else {
            redrawDices(data.currentPlayer, data.diceRoller);
        }
    });
    socket.on('dont move', function () {
        $('.undo').hide();
        $('.timer1,.timer2').text('-');
    });
    socket.on('show timer', function (currentTime, current_player_type) {
        $('.timer1').text('-');
        $('.timer2').text('-');
        var timer = (currentTime / 1000);
        if (currentTime === 0) {
            return;
        }
        if (current_player_type === 0) {
            $('.timer1').text(timer + ' ثانیه');
        }
        else {
            $('.timer2').text(timer + ' ثانیه');
        }
        $('#timer').text(timer);
    });
    socket.on('show disconnect timer', function (timer, current_player_type) {
        $('.timer1,.timer2,#timer').text('-');
        if (timer === 0) {
            return;
        }
        $('#timer').html(timer);
        if (current_player_type === 0) {
            $('.timer1').html('<span style="color: red;">' + timer + ' ثانیه</span>');
        }
        else {
            $('.timer2').html('<span style="color: red;">' + timer + ' ثانیه</span>');
        }
    });
    socket.on('redraw checkers', function (data) {
        // data = {points, currentPlayer, availableMoves, diceRoller}
        redrawCheckers(socket, data);
    });
    socket.on('redraw dices', function (data) {
        // data = {points, currentPlayer, availableMoves, diceRoller}
        redrawBasics(data.currentPlayer);
        redrawDices(data.currentPlayer, data.diceRoller);
    });
    socket.on('opponent connected', function () {
        $('.opponent').removeClass('disconnected').addClass('connected');
    });
    socket.on('opponent disconnected', function () {
        $('.opponent').removeClass('connected').addClass('disconnected');
    });
    $('.undo').click(function () {
        socket.emit('lig undo', game_id);
    });
});

function consoleAddMessage(message) {
    $('#log').append(message.replaceAll(',', '<br/>') + "<br />----------------<br />");
    $('#log').animate({scrollTop: $("#log")[0].scrollHeight - $("#log").height()}, 1000, function () {});
}
function redrawCheckers(socket, data) {
    var availableMoves = data.availableMoves;
    var currentPlayer = data.currentPlayer;
    var points = data.points;

    $(".checker").remove();

    for (var i = 1; i < 25; i++) {
        var point = points[i];
        for (var j = 0; j < point.checkers.length; j++) {
            var checker = point.checkers[j];
            var position = getCheckerPosition(i, j, type);
            var element;
            if (checker.player === 0) {
                element = generateBrownChecker().css('top', position + '%').css('left', 0);
            }
            else {
                element = generateWhiteChecker().css('top', position + '%').css('left', 0);
            }
            $("#point" + i).append(element);
        }
    }

    var player1HomeEl = $("#point-player1-home");
    var checkersCount = points[25].checkers.length;
    for (var i = 0; i < checkersCount; i++) {
        var element;
        if (type === 0) {
            element = generateSmallBrownChecker().css('bottom', (i * 6) + '%').css('left', 0);
        }
        else {
            element = generateSmallBrownChecker().css('top', (i * 6) + '%').css('left', 0);
        }
        player1HomeEl.append(element);
    }

    var player1GraveyardEl = $("#point-player1-graveyard");
    var checkersCount = points[26].checkers.length;
    for (var i = 0; i < checkersCount; i++) {
        var element;
        if (type === 0) {
            element = generateSmallBrownChecker().css('top', (i * 6) + '%').css('left', 0);
        }
        else {
            element = generateBrownChecker().css('bottom', (i * 6) + '%').css('left', 0);
        }
        player1GraveyardEl.append(element);
    }

    var player2HomeEl = $("#point-player2-home");
    var checkersCount = points[27].checkers.length;
    for (var i = 0; i < checkersCount; i++) {
        var element;
        if (type === 0) {
            element = generateSmallWhiteChecker().css('top', (i * 6) + '%').css('left', 0);
        }
        else {
            element = generateSmallWhiteChecker().css('bottom', (i * 6) + '%').css('left', 0);
        }
        player2HomeEl.append(element);
    }

    var player2GraveyardEl = $("#point-player2-graveyard");
    var checkersCount = points[28].checkers.length;
    for (var i = 0; i < checkersCount; i++) {
        var element;
        if (type === 0) {
            element = generateSmallWhiteChecker().css('bottom', (i * 14) + 'px').css('left', 0);
        }
        else {
            element = generateSmallWhiteChecker().css('top', (i * 14) + 'px').css('left', 0);
        }
        player2GraveyardEl.append(element);
    }

    if (currentPlayer !== type) {
        $('.undo').hide();
    }
    if (availableMoves.length && currentPlayer === type) {
        var availableCheckers = '';
        $.each(availableMoves, function (k, v) {
            if (v.from === 25) {
                if (availableCheckers.indexOf('player1-home') === -1) {
                    availableCheckers += (availableCheckers ? ',' : '') + '#point-player1-home .checker';
                }
            }
            else if (v.from === 26) {
                if (availableCheckers.indexOf('player1-graveyard') === -1) {
                    availableCheckers += (availableCheckers ? ',' : '') + '#point-player1-graveyard .checker';
                }
            }
            else if (v.from === 27) {
                if (availableCheckers.indexOf('player2-home') === -1) {
                    availableCheckers += (availableCheckers ? ',' : '') + '#point-player2-home .checker';
                }
            }
            else if (v.from === 28) {
                if (availableCheckers.indexOf('player2-graveyard') === -1) {
                    availableCheckers += (availableCheckers ? ',' : '') + '#point-player2-graveyard .checker';
                }
            }
            else if (availableCheckers.indexOf('point' + v.from) === -1) {
                availableCheckers += (availableCheckers ? ',' : '') + '#point' + v.from + ' .checker';
            }
        });

        $(availableCheckers).dblclick(function () {
            var source = getPointUsingDomId($(this).parent().attr("id"));
            var target;
            for (var item in availableMoves) {
                if (availableMoves[item].from === source) {
                    target = availableMoves[item].to;
                    break;
                }
            }
            if (target) {

                var target_checkers = data.points[target].checkers;
                if (target_checkers.length && target_checkers[0].player === opponentType) {
                    data.points[target].checkers.splice(0, 1);
                    if (opponentType === 0) {
                        var gravyard_checkers = data.points[26].checkers;
                        data.points[26].checkers[gravyard_checkers.length] = {player: opponentType};
                    }
                    else {
                        var gravyard_checkers = data.points[26].checkers;
                        data.points[28].checkers[gravyard_checkers.length] = {player: opponentType};
                    }
                }
                data.points[source].checkers.splice(0, 1);
                data.points[target].checkers[target_checkers.length] = {player: type};
                redrawCheckers(socket, data);

                socket.emit('lig do move', {gid: game_id, source: source, target: target});
                $('.undo').show();
            }
        }).draggable({
            revert: "invalid",
            start: function () {
                var source = getPointUsingDomId($(this).parent().attr("id"));
                $(".ui-droppable").droppable("destroy");
                $.each(availableMoves, function (k, move) {
                    var source_from = move.from;
                    if (source_from === source) {
                        var element = (currentPlayer === 0 ? generateBrownChecker() : generateWhiteChecker());
                        var position = getCheckerPosition(move.to, move.count, type);
                        element.addClass('temp');
                        element.css('top', position + '%');
                        element.css('left', 0);

                        var droppable_tag = '';
                        if (move.to === 25) {
                            droppable_tag = '#point-player1-home';
                        }
                        else if (move.to === 27) {
                            droppable_tag = '#point-player2-home';
                        }
                        else if (move.to !== 26 && move.to !== 28) {
                            droppable_tag = '#point' + move.to;
                        }

                        if (droppable_tag) {
                            $(droppable_tag).droppable({
                                drop: function (event, ui) {
                                    var source = getPointUsingDomId($(ui.draggable).parent().attr("id"));
                                    var target = getPointUsingDomId($(this).attr("id"));
                                    var target_checkers = data.points[target].checkers;
                                    if (target_checkers.length && target_checkers[0].player === opponentType) {
                                        data.points[target].checkers.splice(0, 1);
                                        if (opponentType === 0) {
                                            var gravyard_checkers = data.points[26].checkers;
                                            data.points[26].checkers[gravyard_checkers.length] = {player: opponentType};
                                        }
                                        else {
                                            var gravyard_checkers = data.points[26].checkers;
                                            data.points[28].checkers[gravyard_checkers.length] = {player: opponentType};
                                        }
                                    }
                                    data.points[source].checkers.splice(0, 1);
                                    data.points[target].checkers[target_checkers.length] = {player: type};
                                    redrawCheckers(socket, data);
                                    socket.emit('lig do move', {gid: game_id, source: source, target: target});
                                    $('.undo').show();
                                }
                            });
                        }
                    }
                });
            },
            stop: function () {
                $(".temp").remove();
            }
        });
    }

//        $(".checker").on("click", function () {
//            var source = $(this).parent();
//            var sourcePoint = getPointUsingDomId(source.attr("id"));
//            var checker = sourcePoint.checkers[0];
//            if (checker.player !== GAME.currentPlayer) {
//                return false;
//            }
//            $(".checker").removeClass("selected");
//            $(this).addClass("selected");
//        });
}
function redrawBasics(currentPlayer) {
    $("#player1, #player2").removeClass("selected");
    if (currentPlayer === 0) {
        $("#player1").addClass("selected");
    }
    else {
        $("#player2").addClass("selected");
    }
    //consoleAddMessage('نوبت ' + player.name + ' است');
}
function redrawDices(currentPlayer, diceRoller) {
    $(".dice").addClass('hidden');
    if (currentPlayer === 0) {
        showBrownDice(1, diceRoller.firstValue);
        showBrownDice(2, diceRoller.secondValue);
    }
    else {
        showWhiteDice(1, diceRoller.firstValue);
        showWhiteDice(2, diceRoller.secondValue);
    }
}
function getPointUsingDomId(domId) {
    var id = domId.replace("point", "");
    if (id === "-player1-home") {
        return 25;
    }
    else if (id === "-player1-graveyard") {
        return 26;
    }
    else if (id === "-player2-home") {
        return 27;
    }
    else if (id === "-player2-graveyard") {
        return 28;
    }
    else {
        return parseInt(id);
    }
}
function showWhiteDice(nr, value) {
    var dice = $("#whiteDiceNr" + nr);
    dice.parent().removeClass('hidden');
    dice.removeClass('hidden');
    animateDice(dice, whiteDiceNrs, value);
}
function showBrownDice(nr, value) {
    var dice = $("#brownDiceNr" + nr);
    dice.parent().removeClass('hidden');
    dice.removeClass('hidden');
    animateDice(dice, brownDiceNrs, value);
}
function animateDice(dice, numbers, value) {
    // dice - dice jquery object
    // numbers - array of number classes
    // value - final value 1 to 6
    //dice.removeClass().addClass("dice");

    var count = 0;
    var nrGenerator = new DiceNumberGenerator();

    var showRandomNr = function () {
        if (count < 8) {
            var randomNr = nrGenerator.generate() - 1;
            dice.attr('class', '');
            dice.addClass("dice");
            dice.addClass(numbers[randomNr]);
            count++;
            setTimeout(function () {
                showRandomNr();
            }, 100);
        }
        else {
            dice.attr('class', '');
            dice.addClass('dice');
            dice.addClass(numbers[value - 1]);
        }
    };
    showRandomNr();
}
function generateBrownChecker() {
    return $("<div>").addClass("checker checker-brown pointer");
}
function generateWhiteChecker() {
    return $("<div>").addClass("checker checker-white pointer");
}
function generateSmallBrownChecker() {
    return $("<div>").addClass("topdown-checker topdown-brown checker");
}
function generateSmallWhiteChecker() {
    return $("<div>").addClass("topdown-checker topdown-white checker");
}
function getCheckerPosition(pointNr, checkerNr, type) {
    if (type === 0) {
        if (pointNr >= 1 && pointNr <= 12) { //bottom
            if (checkerNr > 5) {
                return -30 + ((checkerNr - 5) * 20);
            }
            else {
                return 80 - (checkerNr * 20);
            }
        }
        else { // top
            if (checkerNr > 5) {
                return 110 - ((checkerNr - 5) * 20);
            }
            else {
                return checkerNr * 20;
            }
        }
    }
    else if (type === 1) {
        if (pointNr >= 1 && pointNr <= 12) { // top
            if (checkerNr > 5) {
                return 110 - ((checkerNr - 5) * 20);
            }
            else {
                return checkerNr * 20;
            }
        }
        else { // bottom
            if (checkerNr > 5) {
                return -30 + ((checkerNr - 5) * 20);
            }
            else {
                return 80 - (checkerNr * 20);
            }
        }
    }
}
function DiceNumberGenerator() {
    this.generate = function () {
        return Math.floor((Math.random() * 6) + 1);
    };
}
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
Number.prototype.number_format = function (n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};