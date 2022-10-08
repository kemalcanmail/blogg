(function($) {
  "use strict";
  if (isFirstrun) {
    setTimeout(() => {
      $("#WebThumb").css( "background-image", `url('${thumbUrl}')` );
      $('.lazyImg').remove();
    }, 1000);
    setTimeout(() => {
      $("#WebThumb").css( "background-image", `url('${thumbUrl}')` );
    }, 2000);
    setTimeout(() => {
      $("#WebThumb").css( "background-image", `url('${thumbUrl}')` );
    }, 3000);
    setTimeout(() => {
      var request = $.ajax({
        url: updateThumb,
        type: "POST",
        data: {link : domainName},
        dataType: "html"
      });
      
      request.done(function(msg) {
        //console.log(msg);
      });
      
      request.fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
      });
    }, 4500);
  } else {
    $('.lazyImg').remove();
    setTimeout(() => {
      $("#WebThumb").css( "background-image", `url('data:image/png;base64,${thumbUrl}')`);
    }, 750);
  }

  $("#updateWhoisBtnSecondary").on("click", function(e) {
    $("#updateWhoisBtnSecondary span").css("visibility", "hidden");
    $("#whoisLoaderSecondary").removeClass("d-none");
    e.preventDefault();
    var request = $.ajax({
      url: updateWhois,
      type: "POST",
      data: {link : domainName},
      dataType: "html"
    });
    
    request.done(function(msg) {
      //console.log(msg);
      location.reload();
    });
    
    request.fail(function(jqXHR, textStatus) {
      console.log("Request failed: " + textStatus);
    });
  })


})(jQuery);

