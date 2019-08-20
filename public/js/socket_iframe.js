$(document).ready(function(){
    
    const socket = io('http://103.101.162.87:3000');
    var client_info = {
        "user_id": "1234",
    };
    socket.emit('clientInfo', client_info);
    socket.on('connect', () => {});

    socket.on("userLogOut", function(data)
        {            
            //window.location.href = base_url+'/logout';
        });
});