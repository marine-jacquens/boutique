// variable qui permettra de savoir quelle est la boite modal actuellement ouverte
let modal = null
// varaible pour repérer tous ce qui focusable
const focusableSelector="button,a,input,textarea"
let focusables = []
let previouslyFocusedElement = null

//fonction openModal, prend en paramètre l'événement
const openModal = async function (e) {
	e.preventDefault()
	const target = e.target.getAttribute('href')
	if (target.startsWith('#')) {
		modal = document.querySelector(target)
	} else {
		modal = await loadModal(target)
	}
	//sélection des éléments focusables à l'intérieur de la boite modale
	focusables = Array.from(modal.querySelectorAll(focusableSelector))
	//trouver l'élément qui a actuellement le focus et le sauvegarder dans la variable previouslyFocusedElement
	previouslyFocusedElement = document.querySelector(':focus')
	//afficher cette boite modal 
	modal.style.display = null;
	//permet de mettre le focus sur le 1er élément dès le début
	/*focusables[0].focus()*/
	modal.removeAttribute('aria-hidden')
	modal.setAttribute('aria-modal',true)
	//pour fermer la boite modal on écoute le click de modal et on active la fonciton closeModal
	modal.addEventListener('click',closeModal)
	modal.querySelector('.js-modal-close').addEventListener('click',closeModal)
	modal.querySelector('.js-modal-stop').addEventListener('click',stopPropagation)

}

const closeModal = function(e){
	//permet de ne pas aller plus loin si essayer de fermer une modal non existente
	if (modal === null) return
	//lorsque je ferme la boite modal, si l'élément précedemment focus est différent de nul 
	//cela permet de remettre le focus sur l"élément par défaut
	if(previouslyFocusedElement !== null )previouslyFocusedElement.focus()
	e.preventDefault()
	//Animation de fermeture solution 1 : laisser le temps de prévoir une animation css avant de fermer la fenêtre, pour une fermeture progressive
	/*window.setTimeout(function(){
		modal.style.display="none"
		modal = null
	},500)*/
	modal.setAttribute('aria-hidden','true')
	modal.removeAttribute('aria-modal')
	modal.removeEventListener('click',closeModal)
	modal.querySelector('.js-modal-close').removeEventListener('click',closeModal)
	modal.querySelector('.js-modal-stop').removeEventListener('click',stopPropagation)
	// Animation de fermeture solution 2 : écouter la fin de l'animation avant de fermer la fenêtre, 
	//la mettre dans une const pour éviter quelle ne se repète
	const hideModal = function (){
		modal.style.display="none"
		modal.removeEventListener('animationend', hideModal)
		modal = null
	}
	modal.addEventListener('animationend',function(){
		
	})


}

const stopPropagation = function (e) {
	e.stopPropagation()
}

const focusInModal = function(e){
	//court circuite le comportement normal de la tabulation 
	e.preventDefault()
	//dans le tableau focusables on peut trouver l'index de l'élément qui est actuellement focus 
	//fonction f qui doit trouver l'élément qui correspond à l'élément focus
	let index = focusables.findIndex(f => f === modal.querySelector(':focus'))
	//si on a appuyé sur shift
	if(e.shiftKey === true){
		//pour reculer mais peut nous faire arriver à un index négatif
		index--
	}else{
		//à partir de cet index,faire un index++ permet d'ajouter un cran 
		index++
	}
	
	// vérifier si l'index est supérieur ou égal au nbr d'éléments focusables car si on arrive au 
	//dernier il faudra repasser à l'élément 0 
	if(index >= focusables.length){
		index = 0
	}
	//si l'index ets inférieur à 0, l'index sera = au dernier élément
	if(index < 0){
		index = focusables.length - 1
	}
	//maitenant que le cas est géré, je peux prendre l'ensemble des éléments focusables et appliquer 
	//le focus sur l'élément à l'index indiqué
	focusables[index].focus()
}

const loadModal = async function (url) {
	const html = await fetch(url).then(response => response.text())
	console.log(html)
}

document.querySelectorAll('.js-modal').forEach(a => {
	//pour chaque lien ajoute un eventlistener, qd on clique on active la fonction openModal 
	a.addEventListener('click', openModal)
	
})

window.addEventListener('keydown',function (e){
	if(e.key === "Escape" || e.key === "Esc"){
		closeModal(e)
	}
	//écoute du tab - si la modal est visible - on appelle la méthode focusInModal avec en paramètre l'événement
	//permet d'utiliser tab que dans la fenêtre
	if(e.key === 'Tab' && modal !== null){
		focusInModal(e)
	}
})