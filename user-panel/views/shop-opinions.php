<h1>hello</h1>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>

	
function get_wc_all_products() {
    
    var authCode = btoa('ck_c086751120d32cfb9173e832bc9a24e17b1cc3af:cs_943da74ff6cbc2d0d53b401ee35ca519cc6c2177');
    jQuery.ajax({
        method: 'GET',
        url: 'https://www.przygotowaniemotoryczne.com/wp-json/wc/v3/orders',
        headers: {
            'Authorization': "Basic " + authCode
        },
        success: function(response) {
            console.log(response);
        }
    });
}
get_wc_all_products();
</script>

<script>
const wooClientKey = 'ck_c086751120d32cfb9173e832bc9a24e17b1cc3af';
const wooClientSecret = 'cs_943da74ff6cbc2d0d53b401ee35ca519cc6c2177';
const wooUrl = 'https://www.przygotowaniemotoryczne.com/wp-json/wc/v3/orders';

function basicAuth(key, secret) {
    let hash = btoa(key + ':' + secret);
    return "Basic " + hash;
}

let auth = basicAuth(wooClientKey, wooClientSecret);

async function getProducts() {
    try {
        const response = await fetch(wooUrl + 'products', {
            headers: {"Authorization": basicAuth(wooClientKey, wooClientSecret)}
        });
        return await response.json();
        console.log(respone.billing)
    }
    catch (error) {
        // catches errors both in fetch and response.json
        console.log(error);
    }
}

</script>
