

<script>
                var user_id = '{{ Auth::user()->id }}';
                var logout_acount = '{{ route('logoutAcount') }}';
</script> 
<script src="{{ web_asset('public/plugin/firebase.js') }}"></script>
<script>
  // Initialize Firebase  
   var onThiFirebase = {
      mainApp : null,
      initFirebase : function(){ 
        if(this.mainApp === null){
          var firebaseId = {
              apiKey : "AIzaSyBlAVbM0_CoDBEPylYDC9A0RR64gXao688",
              authDomain : "onthiez.firebaseapp.com",
              databaseURL : "https://onthiez.firebaseio.com",
              storageBucket : "onthiez.appspot.com",              
            };
            
          try {
            this.mainApp = firebase.initializeApp(firebaseId);
            
          } catch (e) {

          }
        }
      },
      addUserOnline: function(userId){
        if(userId == '' || userId == undefined || userId == 'undefined')
          { 
            return false;
          }
        var path = "users/login_one_account/user_id_"+userId;        
        var database = this.mainApp.database();
        var ref = database.ref(path);
        ref.set({
          'checking_id':onthi_ez_tracking.visitor(),
          'lastActive': new Date().getTime()
        });
      },
      checkUserOnline: function(userId){
        var path = "users/login_one_account/user_id_"+userId;          
        var database = this.mainApp.database();
        var ref = database.ref(path);
        ref.on('value', function(snapshot) {          
          let data = snapshot.val();          
          let checking_id = data.checking_id;
          if(checking_id == '' || checking_id == undefined || checking_id == 'undefined')
            { 
              return false;
            }
          if(checking_id != onthi_ez_tracking.visitor())
          {
              window.location.href = logout_acount;
          }            
        });
      }


   };   
   onThiFirebase.initFirebase();
   onThiFirebase.addUserOnline(user_id);
   onThiFirebase.checkUserOnline(user_id);

</script>
