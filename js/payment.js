//récupération de la publishable key de stripe
var publishableKey = config.STRIPE_PUBLISHABLE_KEY;

//récupération de la secret key de stripe
var secretKey = config.STRIPE_SECRET_KEY;

console.log(publishableKey);

//création une instance de l'objet Stripe - L'objet Stripe est le point d'accès au reste du kit de développement Stripe.js
var stripe = Stripe(publishableKey);

//Stripe Elements est utilisé pour collecter les données sensibles du formulaire de paiement
//Une instance de Elements permet de gérer un groupe d'élements individuels (Element instances)

//création d'une instance d'élements
var elements = stripe.elements();


//définition du style
var style = {
    base: {
        fontWeight: 100,
        fontSize: '16px',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

//elements.create = méthode de création d'une instance d'un élement spécifique - peut prendre le type d'élément à créer ou une option d'objet
//le type card est "required" - l'objet style permet de customizer l'apparence

//création d'une instance de elements appelé cardNumber
var cardElement = elements.create('cardNumber', {
    style: style
});

//mount()attache l'élément au DOM

cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});

exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});

cvc.mount('#card_cvc');

// Valider les entrées des éléments de la carte
var resultContainer = document.getElementById('paymentResponse');

//le change event est "required"  - il est déclenché lorsque la valeur de l'élément change
cardElement.addEventListener('change', function (event) {

    if (event.error) {
        resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// récupération de l'id du form
var form = document.getElementById('paymentFrm');

// lancement de la fonction createToken lorsque le formulaire est soumis
form.addEventListener('submit', function (e) {
    e.preventDefault();
    createToken();
});

//création d'un token à usage unique pour facturer l'utilisateur
function createToken() {

    stripe.createToken(cardElement).then(function (result) {

        if (result.error) {
            // Informer l'utilisateur s'il y a eu une erreur
            resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
        } else {
            // Envoie le token au serveur
            stripeTokenHandler(result.token);
        }
    });
}

// Callback "required" pour gérer la réponse de stripe
function stripeTokenHandler(token) {

    // Insère l'ID du jeton dans le formulaire pour qu'il soit soumis au serveur.
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}

//https://stripe.com/docs/js/element/mount










