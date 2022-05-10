$(document).ready(function(){
    setInterval(() => {
        setTimeout(() => {
            $.get('/log-manager/check-pin', {}, function(response){
                let parsed = JSON.parse(response)
                if(!parsed?.has_pin){
                    location.reload();
                }
            })   
        }, 200);
    }, 2000);
})