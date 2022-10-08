(function($) {
    let state = JSON.parse(servers);

    console.log(state);
    
    function replaceAllWords(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    const container     = $('#server-container');
    const template      = $('#dom-template').html();
    const none_template = $('#dom-none-template').html();
    const tld           = $('#new-tld');
    const server        = $('#new-server');

    function render() {
        container.html('');
        if(state.length > 0) {

            let html = '';
            state.forEach((item, i) => {
                html += replaceAllWords(template, '{{tld}}', item.tld).replace('{{server}}', item.server).replace('{{i}}', i + 1);
            });
    
            container.html(html);
            $('.delete-server').on('click', function(e) {
                e.preventDefault();
                let tld = $(this).data('tld');
    
                removeState(tld);
            });

        } else {
            container.html(none_template);
        }
    }

    function addState(data) {
        state.push(data);
        render();
    }

    function removeState(tld) {
        state = state.filter(item => item.tld != tld);
        render();
    }

    function showAlert(details) {
        let alertHolder = document.getElementById('alertHolder');
        let alertEmpty = `<div id="emptyAlert" class="alert alert-danger alert-dismissible fade show rounded">
            <span>${details}</span>  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button></div>`;
        alertHolder.innerHTML = alertEmpty;
    }

    function addServer(tld, server) {
        tld    = tld.toLowerCase().trim().replace('.', '');
        server = server.toLowerCase().trim();
        if(!(state.filter(i => i.tld == tld).length)) {
                addState({
                    tld: tld,
                    server: server
                });
        } else {
            showAlert("TLD you are trying to add already exists");
        }
    }


    $('#submit-change').on('click', function(e) {
        $.ajax({
            url: window.location.href,
            method: 'POST',
            data: {
                submit: true,
                servers: JSON.stringify(state)
            },
            success: function(data) {
                window.location.reload();
            }
        })
    })


    
    $('#add-server').on('click', function(e) {
        const tldval    = tld.val();
        const serverval = server.val();
        let whoisRegex = /([\.^abc$])\w+/g ;
        
        if (tldval.length >= 1 || serverval.length >= 1) {
            if (serverval.match(whoisRegex)) {
                addServer(tldval, serverval);
            } else {
                showAlert("Invalid WHOIS Server Entered");
            }

        } else {
            showAlert("Error: TLD or WHOIS Server Filed can't be left empty");
        }
        

        tld.val('');
        server.val('');
    })

    render();
})(jQuery);