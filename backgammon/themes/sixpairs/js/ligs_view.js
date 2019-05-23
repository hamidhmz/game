/* global server_url, password, username, ligs_play_url, ligs_view_url */
$(function () {
    var socket = io(server_url);
    socket.on('connect', function () {
        $('#connecting').hide();
        socket.emit('ligs_view', username, password);
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
    socket.on('pending play', function (gid, t) {
        $('#pending' + gid).text((t) + ' ثانیه');
    });
});