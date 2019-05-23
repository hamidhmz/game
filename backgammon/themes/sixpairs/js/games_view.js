$(function () {
    var socket = io(server_url, {query: 'p=games_view&i=1&g=1'});
    socket.on('connect', function () {
        $('#connecting').hide();
        socket.emit('games_view', username, password, game_id);
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
    socket.on('pre play', function (gid) {
        $('#cancel').remove();
        window.location = play_url + gid;
    });
    socket.on('go', function (where) {
        if ('index' === where) {
            window.location = games_list_url;
        }
        else if ('play' === where) {
            window.location = play_url + game_id;
        }
    });
    socket.on('games list', function (games) {
        if (games && games.length) {
            var output = '';
            var i = 1;
            for (var item in games) {
                var game = games[item];
                var id = game.id;
                var amount = game.amount;
                var player1 = game.player1;
                var player2 = game.player2;
                var type_title = game.type_title;
                var status_id = game.status_id;

                output += '<div class="item">';
                output += '  <div class="row">';
                output += '    <div class="col-xs-1 pull-right">' + (i++) + '</div>';
                output += '    <div class="col-xs-3 pull-right">';
                    if (player1.id != user_id)
                        output += '<a href="' + profile_url + player1.id + '" target="_blank">' + player1.fullname + '</a>';
                    else
                        output += player1.fullname;
                output += '    </div>';
                output += '    <div class="col-xs-2 pull-right">' + type_title + '</div>';
                output += '    <div class="col-xs-3 pull-right">' + amount.number_format() + ' تومان</div>';
                output += '    <div class="col-xs-2 pull-right">';
                if (status_id === 1) {
                    if (player1.id != user_id)
                        output += '    <a class="join-game" data-id="' + id + '">ورود به بازی</a>';
                }
                else {
                    output += 'در حال بازی با <a href="' + profile_url + player2.id + '" target="_blank">' + player2.fullname + '</a>';
                }
                output += '    </div>';
                output += '  </div>';
                output += '</div>';
            }
            $('.waiting-tables .list .body').html(output);
            $('.join-game').click(function () {
                var game_id = $(this).attr('data-id');
                socket.emit('join game', game_id);
            });
        }
        else {
            $('.waiting-tables .list .body').html('');
        }
    });
    $('#cancel').click(function (e) {
        e.preventDefault();
        socket.emit('cancel game', game_id);
    });
});
Number.prototype.number_format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};