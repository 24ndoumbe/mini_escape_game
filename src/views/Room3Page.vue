<template>
  <div class="room-container">
    <h1>La Bibliothèque des Secrets 📚</h1>
    <p class="description">
      Vous êtes dans une bibliothèque remplie de livres anciens. Chaque loupe
      cache une énigme. Résolvez-les toutes pour terminer votre aventure.
    </p>

    <!-- Timer affiché en haut -->
    <div class="timer">Temps restant : {{ formatTempsRestant }}</div>

    <div class="enigme-zone">
      <div class="enigme-image-container">
        <img
          src="@/assets/biblio.jpg"
          alt="Bibliothèque des Secrets"
          class="enigme-image"
        />
        <div
          class="loupe-icon"
          @click="afficherEnigme(1)"
          style="top: 40%; left: 5%"
        >
          🔍
        </div>
        <div
          class="loupe-icon"
          @click="afficherEnigme(2)"
          style="top: 40%; right: 5%"
        >
          🔍
        </div>
        <div
          class="loupe-icon"
          @click="afficherEnigme(3)"
          style="top: 10%; left: 50%; transform: translateX(-50%)"
        >
          🔍
        </div>
      </div>

      <p v-if="!toutesLesEnigmesResolues" class="message-indication">
        Trouvez et résolvez les 3 énigmes pour avancer dans votre quête. 🔑
      </p>
    </div>

    <div v-if="enigmeVisible" class="enigme-container">
      <h2>Énigme :</h2>
      <p>{{ question }}</p>

      <input
        v-model="reponse"
        placeholder="Entrez votre réponse"
        class="reponse-input"
      />
      <button @click="verifierReponse" class="validate-button">
        Valider la réponse
      </button>

      <div v-if="message" class="feedback-message">{{ message }}</div>
    </div>

    <div v-if="toutesLesEnigmesResolues" class="end-game-container">
      <router-link to="/">
        <button class="next-room-button">Retour à l'Accueil 🎉</button>
      </router-link>
      <router-link to="/room1">
        <button class="next-room-button">Choisir une autre Room</button>
      </router-link>
      <router-link to="/result">
        <button class="next-room-button">Voir le Résultat Final 📚</button>
      </router-link>
      <button @click="recommencerAventure" class="next-room-button">
        Recommencer l'Aventure
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Room3Bibliotheque",
  data() {
    return {
      reponse: "",
      message: "",
      enigmeResolue: [false, false, false],
      enigmeVisible: false,
      question: "",
      enigmes: [
        {
          question:
            "Je suis l'auteur du célèbre ouvrage qui commence ainsi : 'Il était une fois, dans une contrée éloignée, un homme dont l'esprit explorait sans cesse les confins du monde des idées.' Quel est le titre de ce livre ?",
          reponse: "Les Voyages de l'Esprit",
        },
        {
          question:
            "Quel est le titre du livre où l’on retrouve le personnage de Sherlock Holmes, le détective légendaire ?",
          reponse: "Les Aventures de Sherlock Holmes",
        },
        {
          question:
            "Dans quel livre l'auteur parle-t-il d'un voyage imaginaire sur un bateau volant ?",
          reponse: "Le Voyage au Centre de la Terre",
        },
      ],
      tempsRestant: 300, // Temps en secondes (5 minutes)
      timer: null,
    };
  },
  computed: {
    toutesLesEnigmesResolues() {
      return this.enigmeResolue.every((resolu) => resolu);
    },
    formatTempsRestant() {
      const minutes = Math.floor(this.tempsRestant / 60);
      const secondes = this.tempsRestant % 60;
      return `${minutes}:${secondes < 10 ? "0" : ""}${secondes}`;
    },
  },
  methods: {
    afficherEnigme(numero) {
      const enigme = this.enigmes[numero - 1];
      this.question = enigme.question;
      this.reponse = "";
      this.enigmeVisible = true;
    },
    verifierReponse() {
      const currentEnigmeIndex = this.enigmes.findIndex(
        (enigme) => enigme.question === this.question
      );

      if (
        this.reponse.trim().toLowerCase() ===
        this.enigmes[currentEnigmeIndex].reponse.toLowerCase()
      ) {
        this.message = "Félicitations ! Vous avez trouvé la réponse 🎉";
        this.enigmeResolue[currentEnigmeIndex] = true;
        this.enigmeVisible = false;
      } else {
        this.message = "Mauvaise réponse, cherchez encore...";
      }
    },
    demarrerTimer() {
      this.timer = setInterval(() => {
        if (this.tempsRestant > 0) {
          this.tempsRestant--;
        } else {
          clearInterval(this.timer);
          this.message = "Temps écoulé ! Vous avez perdu. 😢";
          this.enigmeVisible = false;
        }
      }, 1000);
    },
    recommencerAventure() {
      clearInterval(this.timer);
      this.tempsRestant = 300; // Réinitialise le timer
      this.enigmeResolue = [false, false, false];
      this.enigmeVisible = false;
      this.message = "";
      this.reponse = "";
      this.demarrerTimer();
    },
  },
  mounted() {
    this.demarrerTimer();
  },
  beforeUnmount() {
    clearInterval(this.timer);
  },
};
</script>

<style scoped>
.room-container {
  background: linear-gradient(to bottom, #f3e5ab, #c6a15b);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 50px;
  text-align: center;
}

.timer {
  font-size: 1.5rem;
  font-weight: bold;
  color: #d32f2f;
  margin-bottom: 10px;
}

.description {
  font-size: 1.2rem;
  margin: 20px 0;
  color: #2c3e50;
}

.enigme-zone {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

.enigme-image-container {
  position: relative;
}

.enigme-image {
  width: 600px;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.loupe-icon {
  position: absolute;
  font-size: 2rem;
  cursor: pointer;
  color: red;
}

.message-indication {
  color: #8e44ad;
  font-size: 1.1rem;
  margin-top: 15px;
  font-weight: bold;
}

.enigme-container {
  background: rgba(255, 255, 255, 0.9);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
  width: 80%;
  max-width: 400px;
}

.reponse-input {
  padding: 10px;
  width: 100%;
  margin: 10px 0;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.validate-button {
  background-color: #8e44ad;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  font-size: 1rem;
  margin-top: 10px;
}

.validate-button:hover {
  background-color: #732d91;
}

.feedback-message {
  margin-top: 10px;
  color: #27ae60;
  font-weight: bold;
}

.end-game-container {
  margin-top: 30px;
}

.next-room-button {
  background-color: #3498db;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

.next-room-button:hover {
  background-color: #2980b9;
}
</style>
