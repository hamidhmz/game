$(function () {
    var socket = io(server_url);
    socket.on('connect', function () {
        socket.emit('site_index', username, password);
    });
    socket.on('connect_error', function () {

    });
    socket.on('disconnect', function () {
        $('#users_count').text('0');
    });
    socket.on('users count', function (count) {
        $('#users_count').text(count);
    });
});