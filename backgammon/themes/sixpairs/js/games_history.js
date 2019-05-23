$(function () {
    var socket = io(server_url);
    socket.on('connect', function () {
        $('#connecting').hide();
        socket.emit('games_history', username, password);
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
        window.location = play_url + gid;
    });
});