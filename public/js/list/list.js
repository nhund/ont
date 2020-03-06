$(document).ready(function () {    
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };
    function get_query(){
        var url = location.search;
        if(url === '')
        {
            return url;
        }
        var qs = url.substring(url.indexOf('?') + 1).split('&');
        for(var i = 0, result = {}; i < qs.length; i++){
            qs[i] = qs[i].split('=');
            result[qs[i][0]] = decodeURIComponent(qs[i][1]);
        }
        return result;
    }
    function removeParams(sParam)
    {
                var url = window.location.href.split('?')[0]+'?';
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;
            
                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] != sParam) {
                        url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
                    }
                }
                return url.substring(0,url.length-1);
    }
    $('#filter-price input[name="price-filter"]').on('change',function(){ 
        var $this = $(this);
        var price = $this.val();
        var url = window.location.hostname + window.location.pathname + window.location.hash;
        if(price === undefined)
        { 
            return;
        }
        var params = get_query();
        
        var param_new = '';
        if(params === '')
        {
            param_new = '?price='+price;
        }
        for(var i in params)
        {
            if(i === 'price')
            {
                params[i] = price;

            }else{
                params['price'] = price;
            }            
        }
        var count = 1;
        for(var i in params)
        {
            if(count == 1)
            {
                param_new = param_new + '?'+i+'='+ params[i];
            }else{
                param_new = param_new + '&'+i+'='+ params[i];
            }
            count ++;            
        }
        if(param_new !== '')
        {
            window.location.href = document.location.origin+window.location.pathname + window.location.hash+param_new;
            //console.log(document.location.origin);
        }        
    });
    //loc theo rating
    $('#filter-rating input[name="rating-filter"]').on('change',function(){ 
        var $this = $(this);
        var rating = $this.val();
        var url = window.location.hostname + window.location.pathname + window.location.hash;
        if(rating === undefined)
        { 
            return;
        }
        var params = get_query();
        
        var param_new = '';
        if(params === '')
        {
            param_new = '?rating='+rating;
        }
        for(var i in params)
        {
            if(i === 'rating')
            {
                params[i] = rating;

            }else{
                params['rating'] = rating;
            }            
        }
        var count = 1;
        for(var i in params)
        {
            if(count == 1)
            {
                param_new = param_new + '?'+i+'='+ params[i];
            }else{
                param_new = param_new + '&'+i+'='+ params[i];
            }
            count ++;            
        }
        if(param_new !== '')
        {
            window.location.href = document.location.origin+window.location.pathname + window.location.hash+param_new;
            //console.log(document.location.origin);
        }        
    });

    $('#collection .sort-by').on('change',function(){
        var $this = $(this);
        var sort = $this.val();        
        var url = window.location.hostname + window.location.pathname + window.location.hash;
        if(sort === undefined)
        {
            return;
        }
        var params = get_query();
        var param_new = '';
        if(params === '')
        {
            param_new = '?sortBy='+sort;
        }else{
            for(var i in params)
            { 
                if(i === 'sortBy')
                    {
                        params[i] = sort;

                    }else{
                        params['sortBy'] = sort;
                    }        
            }
        
            var count = 1;
            for(var i in params)
            {
                if(count == 1)
                {
                    param_new = param_new + '?'+i+'='+ params[i];
                }else{
                    param_new = param_new + '&'+i+'='+ params[i];
                }
                count ++;            
            }
        }
        
        if(param_new !== '')
        {
           window.location.href = document.location.origin+window.location.pathname + window.location.hash+param_new;
            //console.log(document.location.origin);
        }        
    });

    $('#collection #filter-vendor input[type="checkbox"]').on('change',function(){
        var $this = $(this);
        var checkbox_val = [];
        $('#collection #filter-vendor input[type="checkbox"]').each(function () {
            if(this.checked)
            {
                checkbox_val.push($(this).val());
            }                        
        });        
        var url = window.location.href;
        if(checkbox_val.length === 0)
        {
            var new_url = removeParams('category_id');
            //console.log(new_url);
            //return;
            window.location.href = new_url;
        } 
        var params = get_query();
        var param_new = '';
        if(params === '')
        {
            param_new = '?category_id='+checkbox_val;
        }else{
            for(var i in params)
            { 
                if(i === 'category_id')
                    {
                        params[i] = checkbox_val;

                    }else{
                        params['category_id'] = checkbox_val;
                    }        
            }
        
            var count = 1;
            for(var i in params)
            {
                if(count == 1)
                {
                    param_new = param_new + '?'+i+'='+ params[i];
                }else{
                    param_new = param_new + '&'+i+'='+ params[i];
                }
                count ++;            
            }
        }
        
        if(param_new !== '')
        {
           window.location.href = document.location.origin+window.location.pathname + window.location.hash+param_new;
           //var a = document.location.origin+window.location.pathname + window.location.hash+param_new;
            //console.log(a);
        }        
    });
    //xoa bo loc
    $('.wrap-filter .clear_filter').on('click',function(){
        window.location.href = document.location.origin+window.location.pathname + window.location.hash;
    });
});