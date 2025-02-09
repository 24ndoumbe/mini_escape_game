<template>
  <div class="home-container">
    <div class="content">
      <h1>Bienvenue dans le Mini Escape Game</h1>
      <p>
        Un jeu d'énigmes captivant vous attend. Cliquez sur "Démarrer" pour
        commencer votre aventure !
      </p>

      <!-- Message informatif pour l'utilisateur -->
      <div class="info-message">
        <p>
          Vous pouvez jouer sans vous connecter, mais pour sauvegarder votre
          progression, vous pouvez vous inscrire et vous connecter !
        </p>
      </div>

      <button @click="goToGame">Démarrer</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomePage",
  methods: {
    goToGame() {
      this.$router.push("/game");
    },
  },
};
</script>

<style scoped>
/* Supprime les marges et assure une pleine couverture */
html,
body,
.home-container {
  margin: 0;
  padding: 0;
  height: 100vh;
}
/* Style du conteneur principal */
.home-container {
  background-image: url("@/assets/AdobeStock_313905773-Senegal-Ile-de-Goree.webp"); /* Référence ton image ici */
  background-size: cover;
  background-position: center;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-family: "Arial", sans-serif;
  text-align: center;
}

/* Conteneur du contenu du texte */
.content {
  background-color: rgba(
    0,
    0,
    0,
    0.6
  ); /* Transparence pour que l'arrière-plan soit visible */
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
  max-width: 600px;
  width: 100%;
}

/* Style du titre */
h1 {
  font-size: 3rem;
  margin-bottom: 20px;
  font-weight: 700;
  text-transform: uppercase;
}

/* Style du paragraphe */
p {
  font-size: 1.2rem;
  margin-bottom: 30px;
  line-height: 1.5;
}

/* Message informatif */
.info-message {
  font-size: 1.1rem;
  color: #ffd700;
  margin-bottom: 20px;
}

/* Style du bouton */
button {
  background-color: #4caf50;
  color: white;
  font-size: 1.2rem;
  border: none;
  padding: 15px 30px;
  border-radius: 10px;
  cursor: pointer;
  transition: transform 0.3s ease, background-color 0.3s ease;
}

button:hover {
  background-color: #45a049;
  transform: scale(1.1);
}

/* Animation pour le texte de la page */
h1,
p {
  animation: fadeIn 1.5s ease-in-out;
}

/* Animation de fade-in */
@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(50px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
