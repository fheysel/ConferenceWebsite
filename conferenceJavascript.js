// window.onload=function() {
//   document.getElementById("attendeeTypeDropdown").onchange=function() {
//     var type = this.value;
//     alert("hello poop");
//     if (type != "student"){
//         document.getElementById('studentBucket').style.visibility='hidden';
//     }
//     else if (type != "sponsor") {
//       document.getElementById('sponsorBucket').style.backgroundColor='#e1e1d0';
//     }
//
//     // document.getElementById('list_report').style.visibility='hidden';
//     // document.getElementById('formTag').style.visibility='hidden';
//   }
// }

//attempt 2
// var signupParent = document.getElementById("signupParent");
// attendeeParent.addEventListener("click", clickReact, false);
//
// function clickReact(e){
//   if (e.target != e.currentTarget) {
//     var signupDropDown = document.getElementById('attendeeTypeDropdown');
//     if(signupDropDown.value != "student"){
//       document.getElementById('studentBucket').style.backgroundColor = "red";
//     }
//     else{
//       alert("D!bs only allows you to have 3 hours reserved at a time")
//     }
//
//     // alert("hello " + e.target.id + " poop " + e.target.className);
//   }
//   e.stopPropagation;
// }

//attempt 3
function attendeeTypeChange() {
    var selector = document.getElementById('attendeeTypeDropdown');
    var value = selector[selector.selectedIndex].value;

    console.log("poop");
}

document.getElementById('signupParent').addEventListener('click', attendeeTypeChange();
