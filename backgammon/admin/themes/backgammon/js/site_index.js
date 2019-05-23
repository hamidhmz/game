$(function () {
    var socket = io(server_url);
    socket.on('connect', function () {
        //$('#connecting').hide();
        socket.emit('admin_site_index', username, password);
    });
    socket.on('connect_error', function () {
        $('.online-users-count').html('( ? )');
        $('.online-users').html('<li class="text-center">در حال اتصال به سرور ...</li>');

        $('.online-games-count').html('( ? )');
        $('.online-games').html('<li class="text-center">در حال اتصال به سرور ...</li>');
        //$('#connecting').show();
    });
    socket.on('disconnect', function () {
        $('.online-users-count').html('( ? )');
        $('.online-users').html('<li class="text-center">در حال اتصال به سرور ...</li>');

        $('.online-games-count').html('( ? )');
        $('.online-games').html('<li class="text-center">در حال اتصال به سرور ...</li>');
        //$('#connecting').show();
    });
    socket.on('message', function (message, data) {
        alert(message);
    });
    socket.on('users count', function (users) {
        $('.online-users').html('');
        var len = Object.keys(users).length;
        $('.online-users-count').html(len ? '(&nbsp;' + len + '&nbsp;کاربر&nbsp;)' : '');
        if (len) {
            for (var index in users) {
                var user = users[index];
                $('.online-users').append('<li>' + user.fullname + '</li>');
            }
        }
        else {
            $('.online-users').html('<li class="text-center">هیچ کاربری آنلاین نیست!</li>');
        }
    });
    socket.on('games count', function (games) {
        $('.online-games').html('');
        var len = Object.keys(games).length;
        $('.online-games-count').html(len ? '(&nbsp;' + len + '&nbsp;بازی&nbsp;)' : '');
        if (len) {
            for (var index in games) {
                var game = games[index];
                if (game.player2) {
                    
                    $('.online-games').append('<li>' + game.player1.fullname + ' vs ' + game.player2.fullname + ' ( ' + game.total_amount.number_format() + ' تومان )</li>');
                }
                else {
                    $('.online-games').append('<li>' + game.player1.fullname + '&nbsp;<small>درانتظار حریف</small>&nbsp;( ' + game.total_amount.number_format() + ' تومان )</li>');
                }
            }
        }
        else {
            $('.online-games').html('<li class="text-center">هیچ بازی در حال انجام نیست!</li>');
        }
    });
});
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
Number.prototype.number_format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};