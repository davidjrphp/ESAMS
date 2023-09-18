function sign(){
    var mail = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var pass = document.getElementById("pass").value;
    var pass2 = document.getElementById("pass2").value;
    if(mail == ""){
        alert('You must enter your Email Address');
    }
    else if(username == ""){
        alert('you must enter your password');
    }
    else if(pass == ""){
        alert('you must enter your Username');
    }else{
        if(pass != pass2){
            alert('type a matching password');
        }else{
            alert('Your account has been created successfully');
        }
    }
}