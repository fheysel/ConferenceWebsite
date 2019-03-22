//Attendee Dropdown
var signupParent = document.getElementById("signupParent");
signupParent.addEventListener("click", clickReact, false);

function clickReact(e){
  if (e.target != e.currentTarget) {
    var signupDropDown = document.getElementById('attendeeTypeDropdown');
    if(signupDropDown.value == "student"){
      document.getElementById('studentBucket').style.backgroundColor = "white";
      document.getElementById('schoolNameInput').disabled = false;
      document.getElementById('studentNumInput').disabled = false;
      document.getElementById('roomNumInput').disabled = false;
    }
    else{
      document.getElementById('studentBucket').style.backgroundColor = "#e1e1d0";
      document.getElementById('schoolNameInput').disabled = true;
      document.getElementById('studentNumInput').disabled = true;
      document.getElementById('roomNumInput').disabled = true;
    }
    if (signupDropDown.value == "sponsor") {
      document.getElementById('sponsorBucket').style.backgroundColor = "white";
      document.getElementById('companyNameInput').disabled = false;
    }
    else{
      document.getElementById('sponsorBucket').style.backgroundColor = "#e1e1d0";
      document.getElementById('companyNameInput').disabled = true;
    }
  }
  e.stopPropagation;
}

//Popups
// var signupParent = document.getElementById("attendee");
// signupParent.addEventListener("click", clickReact, false);
