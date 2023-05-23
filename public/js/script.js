

//Bouton d'ouverture' de la galerie d'images

  function showGallery() {
    $('#gallery-container').show();
    document.body.classList.add('gallery-active');
  }

//Bouton de fermeture de la galerie d'images

  function closeGallery() {
    var gallery = document.getElementById('gallery-container');
    gallery.style.display = "none";
    document.body.classList.remove('gallery-active');
  }
  
//Responsivité du lien "infos pratiques"

  $('#gallery').on('click', 'img', function() {
    $(this).toggleClass('enlarge');
  });

  function updateInfoPratiquesLink() {
    var link = document.getElementById("infos-pratiques-link");
    if (window.innerWidth < 1220) {
      link.href = "#infos-pratiques-mobile";
    } else {
      link.href = "#infos-pratiques";
    }
  }

// Appel initial pour mettre à jour le lien en fonction de la largeur de l'écran au chargement de la page
  updateInfoPratiquesLink();
  
// Écouteur d'événement pour mettre à jour le lien lors du redimensionnement de l'écran
  window.addEventListener("resize", updateInfoPratiquesLink);

  
//MENU HAMBURGER

  const hamburger = document.getElementById("hamburger");
  const mobileNav = document.querySelector(".mobile-nav");

  hamburger.addEventListener("click", () => {
    mobileNav.classList.toggle("active");
  });

// CAROUSEL

const carouselImages = document.querySelector('.carousel-images');
const navButtons = document.querySelectorAll('.nav-button');

let currentIndex = 0;

// Cache toutes les images excepté la première

for (let i = 1; i < carouselImages.children.length; i++) {
  carouselImages.children[i].style.display = 'none';
}

// Ajout d'un écouteur d'événements de clic aux boutons de navigation

for (let i = 0; i < navButtons.length; i++) {
  navButtons[i].addEventListener('click', () => {
    // Supprimer la classe active de tous les boutons de navigation
    for (let j = 0; j < navButtons.length; j++) {
      navButtons[j].classList.remove('active');
    }

    // Afficher l'image correspondant au bouton cliqué.
    currentIndex = parseInt(navButtons[i].getAttribute('data-index')) - 1;
    carouselImages.children[currentIndex].style.display = 'block';

    // Ajouter la classe active au bouton cliqué.
    navButtons[i].classList.add('active');

    // Masquer toutes les autres images.
    for (let j = 0; j < carouselImages.children.length; j++) {
      if (j !== currentIndex) {
        carouselImages.children[j].style.display = 'none';
      }
    }
  });
}

// Afficher la première image et définir le premier bouton comme actif.
carouselImages.children[currentIndex].style.display = 'block';
navButtons[currentIndex].classList.add('active');

const carouselImagesList = document.querySelectorAll('.carousel-images img');
const images = [
  ['images/1685_w1024h576c1cx1500cy2250.jpg', 'images/grillon-charentais-350g.jpeg', 'images/pains-c3a0-lail-adelepomme-4.webp'],
  ['images/mogettes-de-vendee-a-la-graisse-de-canard-51-recette-jambon-de-vendee-et-mogettes-scaled-1.jpg', 'images/botifarra.jpg', 'images/IMG_5729.jpeg'],
  ['images/77778_w1024h768c1cx3024cy2016.webp', 'images/Tourtisseaux.jpg', 'images/23777155_s_3.735x0-is.jpg']
];

const titles = [
  ['Briochine foie gras', 'Grillons de porc', 'Préfou'],
  ['Mogettes Jambon', 'Boudine grillée', 'Potée choux vert'],
  ['Brioche tressée Vendéenne', 'Tourtisseaux', 'Caillebotte']
];
function updateCarouselImages(imgIndex) {
  for (let i = 0; i < carouselImagesList.length; i++) {
    carouselImagesList[i].src = images[imgIndex][i];
    carouselImagesList[i].alt = titles[imgIndex][i];
    carouselImagesList[i].title = titles[imgIndex][i];
  }
}


var entreesContainer = null;
var platsContainer = null;
var dessertsContainer = null;
var formulesContainer = null;
var boissonsContainer = null;

$(document).ready(function() {

   entreesContainer = document.querySelector('#entrees-container');
   platsContainer = document.querySelector('#plats-container');
   dessertsContainer = document.querySelector('#desserts-container');
   formulesContainer = document.querySelector('#formules-container');
   boissonsContainer = document.querySelector('#boissons-container');

  if (entreesContainer != undefined){
    updateCarouselImages(0);
  } else if (platsContainer != undefined){
    updateCarouselImages(1);
  } else if (dessertsContainer != undefined){
    updateCarouselImages(2);
  }

});
function dateChange() {
  var dateInput = document.querySelector('#reservation_form_date');
  var heureSelect = document.querySelector('#reservation_form_heure');

  var selectedDate = new Date(dateInput.value);
  var today = new Date();
  var todayHour = today.getHours();
  var todayMin = today.getMinutes();

  // Vider la liste déroulante des heures
  heureSelect.innerHTML = '';

  if(selectedDate.getDate() !== today.getDate()){
    if (selectedDate.getDay() === 6) {
      for (var hour = 12; hour <= 13; hour++) {
        addHourOption(hour, heureSelect);
        addHalfHourOption(hour, heureSelect);
      }
      addHourOption(14, heureSelect);

      // Ajouter les heures disponibles entre 19h et 22h
      for (var hour = 19; hour <= 22; hour++) {
        addHourOption(hour, heureSelect);
        addHalfHourOption(hour, heureSelect);
      }
    } else {
      for (var hour = 12; hour <= 13; hour++) {
        addHourOption(hour, heureSelect);
        addHalfHourOption(hour, heureSelect);
      }
      addHourOption(14, heureSelect);

      // Ajouter les heures disponibles entre 19h et 21h
      for (var hour = 19; hour <= 21; hour++) {
        addHourOption(hour, heureSelect);
        addHalfHourOption(hour, heureSelect);
      }
      addHourOption(22, heureSelect);
    }
  }else {
    if (selectedDate.getDay() === 6) {
      if (todayHour < 11 || (todayHour === 11 && todayMin <= 30)) {
        for (var hour = 12; hour <= 13; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour > 11 || (todayHour === 11 && todayMin >= 30)) {
        for (var hour = todayHour+1; hour <= 13; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour < 13 || (todayHour === 13 && todayMin <= 30)){
        addHourOption(14, heureSelect);
      }

      // Ajouter les heures disponibles entre 19h et 22h
      if (todayHour < 18 || (todayHour === 18 && todayMin <= 30)) {
        for (var hour = 19; hour <= 21; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour > 18 || (todayHour === 18 && todayMin >= 30)){
        for (var hour = todayHour+1; hour <= 22; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
    } else {
      if (todayHour < 11 || (todayHour === 11 && todayMin <= 30)) {
        for (var hour = 12; hour <= 13; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour > 11 || (todayHour === 11 && todayMin >= 30)) {
        for (var hour = todayHour+1; hour <= 13; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour < 13 || (todayHour === 13 && todayMin <= 30)){
      addHourOption(14, heureSelect);
      }
      // Ajouter les heures disponibles entre 19h et 21h
      if (todayHour < 18 || (todayHour === 18 && todayMin <= 30)) {
        for (var hour = 19; hour <= 21; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour > 18 || (todayHour === 18 && todayMin >= 30)){
        for (var hour = todayHour+1; hour <= 21; hour++) {
          addHourOption(hour, heureSelect);
          addHalfHourOption(hour, heureSelect);
        }
      }
      if (todayHour < 21 || (todayHour === 21 && todayMin <= 30)){
      addHourOption(22, heureSelect);
      }
    }
  }
}

function addHourOption(hour, selectElement) {
  var option = document.createElement('option');
  option.text = hour + ':00';
  option.value = hour + ':00';
  selectElement.add(option);
}

function addHalfHourOption(hour, selectElement) {
  var option = document.createElement('option');
  option.text = hour + ':30';
  option.value = hour + ':30';
  selectElement.add(option);
}

// Eléments HTML correspondant aux modales de connexion, d'inscription et de réservation

const modalConnexion = document.querySelector('#connexionModal');
const modalInscription = document.querySelector('#inscriptionModal');
const lienInscription = document.querySelector('#lienInscription');
const errorInscription = document.querySelector('#errorInscription');
const modalReservation = document.querySelector('#reservationModal');

// Clic sur le bouton de réservation
function btnReservationClick(){
  afficherModal(modalReservation);
}

// Ajouter un écouteur d'événement de clic sur le bouton de fermeture de la modale de réservation
modalReservation.querySelector('.close-formular').addEventListener('click', function() {
  masquerModal(modalReservation);
});

// Afficher une modale spécifiée
function afficherModal(modal) {
  modal.classList.add('show');
  modal.style.display = 'block';
  errorInscription.style.display = 'none';
}

// Masquer une modale spécifiée
function masquerModal(modal) {
  modal.classList.remove('show');
  modal.style.display = 'none';
}

// Clic sur le bouton de connexion
function btnConnexionClick(){
  afficherModal(modalConnexion);
}

// Ajouter un écouteur d'événement de clic sur le lien d'inscription pour basculer vers la modale d'inscription
lienInscription.addEventListener('click', function() {
  masquerModal(modalConnexion);
  afficherModal(modalInscription);
});

// Ajouter un écouteur d'événement de clic sur le bouton de fermeture de la modale de connexion
modalConnexion.querySelector('.close-formular').addEventListener('click', function() {
  masquerModal(modalConnexion);
});

// Ajouter un écouteur d'événement de clic sur le bouton de fermeture de la modale d'inscription
modalInscription.querySelector('.close-formular').addEventListener('click', function() {
  masquerModal(modalInscription);
});



