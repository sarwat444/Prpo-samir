$(document).ready(function(){


   const couplebackground = document.querySelector(".couplempodel  .mug-modal .hinterground .couplebackgroundimage");
   const couplenoimage = document.querySelector(".couplempodel  .mug-modal .hinterground .noimage");
   const coupleproductimages = document.querySelectorAll("#coupleimagescontent1 .list-images ul li img");
   function couplechangeImage(e) {
       couplebackground.src = e.target.src;
       $(couplebackground).css('display' , "block");
   }
   coupleproductimages.forEach(image => image.addEventListener("click", couplechangeImage));

   $('.couplenoimage').click(function(){
       $(couplebackground).css('display' , "none");
   })
   //END Couple Background
   /*START  Mannn */
   const mannimage = document.querySelector(".couplempodel  .mug-modal .mann .mannimage");
   const mannimages = document.querySelectorAll(".couplempodel #content2 .list-images ul li img");
   function changemannimages(e) {
       mannimage.src = e.target.src;
       $(mannimage).css('display' , "block");
   }
   mannimages.forEach(image => image.addEventListener("click", changemannimages));
   /*End Mann */

   /*START  Frau */
   const frauimage = document.querySelector(".couplempodel  .mug-modal .frau .frauimage");
   const frauimages = document.querySelectorAll(".couplempodel #fraucontent .list-images ul li img");
   function changefrauimages(e) {
       frauimage.src = e.target.src;
       $(frauimage).css('display' , "block");
   }
   frauimages.forEach(image => image.addEventListener("click", changefrauimages));



   //groub 3....
   const couple1unbenantimage = document.querySelector(".couplempodel  .mug-modal .Unbenannt .couple1unbenantimage");
   const couple1unbenantimages = document.querySelectorAll(".couplempodel #couple1Unbenannt .list-images ul li img");
   function changecouple1unbenantimage(e) {
       couple1unbenantimage.src = e.target.src;
       $(couple1unbenantimage).css('display' , "block");
   }
   couple1unbenantimages.forEach(image => image.addEventListener("click", changecouple1unbenantimage));

   //groub 4....
   const couple2unbenantimage = document.querySelector(".couplempodel  .mug-modal .Unbenannt2 .couple2unbenantimage");
   const couple2unbenantimages = document.querySelectorAll(".couplempodel #couple2Unbenannt  .list-images ul li img");
   function changecouple2unbenantimage(e) {
       couple2unbenantimage.src = e.target.src;
       $(couple2unbenantimage).css('display' , "block");
   }
   couple2unbenantimages.forEach(image => image.addEventListener("click", changecouple2unbenantimage));

   /* Start Font Typing */
   $('.typingdiloge #coupletyping').on('keyup', function(){
       var o  = $(this).val() ;
       $('#coupletyped p').text(o);
   });
   $('.typingdiloge #fontfamily').on('change', function(){
       var p  = $(this).val() ;
       $('#coupletyped p').css('font-family' , p);
   });
   $('.typingdiloge #fsize').on('change', function(){
       var q  = $(this).val() ;
       $('#coupletyped p').css('font-size' , q+'px');
   });
   $('.typingdiloge #fcolor').on('change', function(){
       var r  = $(this).val() ;
       $('#coupletyped p').css('color' , r);
   });
 
    
}) ; 