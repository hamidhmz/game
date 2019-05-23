$(function () {
    var socket = io(server_url);
    socket.on('connect', function () {
        $('#connecting').hide();
        socket.emit('games_index', username, password);
    });
    socket.on('connect_error', function () {
        $('#connecting').show();
        $('.waiting-tables .list .body').text('');
        $('.online-users').text('');
    });
    socket.on('disconnect', function () {
        $('#connecting').show();
        $('.waiting-tables .list .body').text('');
        $('.online-users').text('');
    });
    socket.on('message', function (message, data) {
        alert(message);
    });
    socket.on('pre play', function (gid) {
        window.location = play_url + gid;
    });

    socket.on('users count', function (users) {
        $('.online-users').html('');
        var len = Object.keys(users).length;
        $('.online-users-count').text(len);
        if (len) {
            for (var index in users) {
                var user = users[index];
                $('.online-users').append('<li>' + user.fullname + '</li>');
            }
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
                output += '    <div class="col-xs-3 pull-right"><a href="' + profile_url + player1.id + '" target="_blank">' + player1.fullname + '</a></div>';
                output += '    <div class="col-xs-2 pull-right">' + type_title + '</div>';
                output += '    <div class="col-xs-3 pull-right">' + amount.number_format() + ' تومان</div>';
                output += '    <div class="col-xs-2 pull-right">';
                if (status_id === 1) {
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
});
Number.prototype.number_format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};