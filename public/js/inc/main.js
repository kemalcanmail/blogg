(function($) {
  "use strict";
  $("#domainInput").on("submit", function(e) {
    e.preventDefault();

    let domainName = $("#searchBox").val().replace(/(https?:\/\/)?(www.)?/i, '');
    domainName = domainName.toLowerCase();
    
    let searchFiled = $("#domainInput");
    if (CheckIsValidDomain(domainName)) {
      $("#searchBtn span").css("visibility", "hidden");
      $("#whoisLoader").removeClass("d-none");
      

      let url = getWhoisUrl+domainName;
      var request = $.ajax({
        url: url,
        type: "POST",
        data: {link : domainName},
        dataType: "html"
      });

      let domainLenght = domainName.length;
      let tldIndex = domainName.indexOf('.');
      let tld = domainName.slice(tldIndex, domainLenght);
      
      request.done(function(msg) {
        $("#searchBtn span").css("visibility", "visible");
        $("#whoisLoader").addClass("d-none");

        switch(msg) {
          case "++[ERROR_NOT_A_DOMAIN]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner"><b>${domainName}</b> is not a valid Domain Name</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_NOTHING_ENTERED]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner">Domain Name field can't be empty</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_UNSUPPORTED_TLD]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner"><b>${tld}</b> is not supported TLD</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_NO_MATCH]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-success shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner"><b>${domainName}</b> is available for registration <b> <br/> <a class="btn btn-sm btn-by py-1 px-3 mt-1 text-white shadow-md" href="#">Click here to register</a></b></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[PLZ_WAIT_SOME_TIME]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner">Hey hey, slow down you are going to fast</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_INPUT]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();
              
            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner">Something went wrong or ${domainName} is invalid domain</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_NOTHING_IN_ARRAY]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();

            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner"><b>${domainName}</b> is not a valid Domain Name</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          case "++[ERROR_NOTHING_IN_ARRAY]++":
            if ($("#domainInputAlert")) 
            $("#domainInputAlert").remove();

            searchFiled.after(`
              <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
                <span class="alertInner"><b>${domainName}</b> is not a valid Domain Name</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            `);
            break;
          default: 
            if (ifMain) {
              var x = msg.indexOf('<body>');
              var y = msg.indexOf('</body>');
              var s = msg.slice(x,y);
              $("body").html(s);
  
              let stateObj = { id: domainName }; 
              if (ifMain) {
                window.history.replaceState(stateObj, `${domainName} WHOIS`, `whois/${domainName}`);
              } else {
                window.history.replaceState(stateObj, `${domainName} WHOIS`, `${domainName}`);
              }
  
              setTimeout(() => {
                if (isFirstrun) {
                  $("#WebThumb").css( "background-image", `url('${thumbUrl}')` );
                } else {
                  $("#WebThumb").css( "background-image", `url('data:image/png;base64,${thumbUrl}')`);
                }
              }, 1000);
            } else {
              location.assign(getWhoisUrl+domainName);
            }
            
        }
      });
      
      request.fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
      });
    } else {
      if (domainName == "") {
        if ($("#domainInputAlert")) 
        $("#domainInputAlert").remove();
        
        searchFiled.after(`
          <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
            <span class="alertInner">Domain Name field can't be empty</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
        `);
      } else {
        if ($("#domainInputAlert")) 
        $("#domainInputAlert").remove();

        searchFiled.after(`
        <div id="domainInputAlert" class="alert alert-danger shadow-mdalert-dismissible fade hide show" role="alert">
          <span class="alertInner"><b>${domainName}</b> is not a valid Domain Name</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      `);
      }
     
    }
    
    function CheckIsValidDomain(domain) { 

      //var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/);


      var re = new RegExp(/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/gm); 
      
      return domain.match(re);
    } 

  })

})(jQuery);

