


$("#mob").focus(function (){

   $("#mob").val("+98")

})

$("#eye").mousedown(function (){
   $("#pass").attr("type","text")
})

$("#eye").mouseup(function (){
   $("#pass").attr("type","password")
})






//   CheckBox
function check_uncheck_checkbox(isChecked) {
   if(isChecked) {
      $('input[name="userCheck[]"]').each(function() {
         this.checked = true;
      });
   } else {
      $('input[name="userCheck[]"]').each(function() {
         this.checked = false;
      });
   }
}

$(".shUser").click(function (){

     $(".user").parent().parent().removeClass("hidden")
     $(".manager").parent().parent().addClass("hidden")
     $(".writer").parent().parent().addClass("hidden")

})


$(".shManager").click(function (){

   $(".manager").parent().parent().removeClass("hidden")
   $(".user").parent().parent().addClass("hidden")
   $(".writer").parent().parent().addClass("hidden")

})


$(".shWriter").click(function (){

   $(".writer").parent().parent().removeClass("hidden")
   $(".manager").parent().parent().addClass("hidden")
   $(".user").parent().parent().addClass("hidden")

})


$(".alluser").click(function (){

    $(".writer").parent().parent().removeClass("hidden")
    $(".manager").parent().parent().removeClass("hidden")
    $(".user").parent().parent().removeClass("hidden")

})
