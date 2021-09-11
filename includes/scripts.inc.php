<script src="<?php echo $rootURL; ?>assets/js/popper.min.js"></script>
<script src="<?php echo $rootURL; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>

    const number_format = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    const invest = () => {
        $("#invest-overlay").fadeToggle('fast');
        $("#invest-modal").fadeToggle('fast');
    }

    const modal = {
        signup() {
            $("#login").hide();
            $("#reset").hide();
            $("#signup").fadeToggle("slow");
        },

        login() {
            $("#signup").hide();
            $("#reset").hide();
            $("#login").fadeToggle("slow");
        },

        reset() {
            $("#signup").hide();
            $("#login").hide();
            $("#reset").fadeToggle("slow");
        }

    };

    const payment = (id, amount, email, name) => {
        FlutterwaveCheckout({
        public_key: "FLWPUBK-790c151624a80ca7885b11b276482e7f-X",
        tx_ref: "RX1",
        amount: amount,
        currency: "NGN",
        country: "NG",
        payment_options: " ",
        customer: {
            email: email,
            name: name,
        },
        callback: function (data) { // specified callback function
            console.log(data);
            if(data.status == 'successful'){
                investment.confirm(id);
            }
        },
        customizations: {
            title: "Dacha Finance",
            description: "Payment for investment",
            logo: "http://dachafinance.com/dashboard/assets/images/logo.jpg",
        },
        });
    }

    const investment = {
        confirm(id) {
            let data = 'investment='+id+'&cmd=confirm';
            $.post('api.php', data, function(result){
                if(result !== false){
                    console.log(result);
                }
            });
        }, 

        activate(id) {
            let data = 'investment='+id+'&cmd=data';
            $.post('api.php', data, function(result){
                if(result !== false){
                    payment(id, result.plan.amount, result.user.email, result.user.first_name+" "+result.user.last_name)
                    // console.log(result);
                }
            });
        },

        delete(id){
            let data = 'investment='+id+'&cmd=delete';
            if(confirm('Are you sure you want to cancel this plan?')){
                $.post('api.php', data, function(result){
                    if(result !== false){
                        location.reload();
                    } else {
                        alert('An error occured! Please try again.');
                    }
                });
            }
        },

        complete(id){
            let data = 'investment='+id+'&cmd=complete';
            $.post('api.php', data, function(result){
                if(result !== false){
                    location.reload();
                } else {
                    alert('An error occured! Please try again.');
                }
            });
        },
    };

    const counter = (now, start, end, roi, element) => {
        let ppsec = roi / (end - start);
        let current = (now - start) * ppsec;
        let newAmount;
        setInterval((start, end) => {
            newAmount = current + ppsec;
            $("#"+element).html(newAmount); 
        }, 1000);
    };

</script>