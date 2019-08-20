$(document).ready(function(){
<<<<<<< HEAD
    
    const socket = io('wss://103.101.162.87:3000');
    var client_info = {
        "user_id": user_id,
    };
    socket.emit('clientInfo', client_info);
    socket.on('connect', () => {});
=======
    var iframeManagerChat = '<iframe id="socket_iframe" src="//node1.onthiez.com"></iframe>';
        //khoi tao box ben phai
    $('#socket_id').append(iframeManagerChat);
>>>>>>> d9b4c00faf15462533406e918c94186f5c88e416

    // const socket = io('//103.101.162.87:3000');
    // var client_info = {
    //     "user_id": user_id,
    // };
    // socket.emit('clientInfo', client_info);
    // socket.on('connect', () => {});

    // socket.on("userLogOut", function(data)
    //     {            
    //         window.location.href = base_url+'/logout';
    //     });
});