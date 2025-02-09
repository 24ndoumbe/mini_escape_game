<template>
  <div class="room-container">
    <h1>Voyage dans le Temps 🌍⏳</h1>
    <p class="description">
      Cliquez sur les points d'interrogation pour découvrir les énigmes et
      résoudre le mystère.
    </p>

    <!-- Timer affiché en haut -->
    <div class="timer">Temps restant : {{ formatTempsRestant }}</div>

    <!-- Image avec trois points d'interrogation dans une même div -->
    <div class="enigme-zone">
      <div class="enigme-image-container">
        <img
          src="@/assets/enigme-policiere.png"
          alt="Carte de l'énigme"
          class="enigme-image"
        />
        <!-- Points d'interrogation sur l'image -->
        <div
          class="point-interrogation"
          @click="afficherEnigme(1)"
          style="top: 20%; left: 15%"
        >
          ❓
        </div>
        <div
          class="point-interrogation"
          @click="afficherEnigme(2)"
          style="top: 40%; left: 50%"
        >
          ❓
        </div>
        <div
          class="point-interrogation"
          @click="afficherEnigme(3)"
          style="top: 60%; left: 85%"
        >
          ❓
        </div>
      </div>
    </div>

    <!-- Section pour la réponse de l'énigme -->
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

    <!-- Bouton pour passer à la Room suivante si toutes les énigmes sont résolues -->
    <router-link v-if="toutesLesEnigmesResolues" to="/room3">
      <button class="next-room-button">Passer à la Room suivante 🚪</button>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "Room2Enquete",
  data() {
    return {
      enigmeVisible: false,
      question: "",
      reponse: "",
      message: "",
      enigmeResolue: [false, false, false],
      enigmes: [
        {
          question: "Qui est le suspect principal dans cette enquête ?",
          reponse: "Le Docteur",
        },
        { question: "Où a eu lieu le crime ?", reponse: "Le manoir" },
        { question: "Quelle arme a été utilisée ?", reponse: "Un couteau" },
      ],
      currentEnigmeIndex: 0,
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
        this.message = "Bravo ! Vous avez résolu l'énigme 🎉";
        this.enigmeResolue[currentEnigmeIndex] = true;
        this.enigmeVisible = false;
        this.currentEnigmeIndex++;
        if (this.currentEnigmeIndex < this.enigmes.length) {
          this.afficherEnigme(this.currentEnigmeIndex + 1);
        }
      } else {
        this.message = "Mauvaise réponse. Essayez encore !";
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
  text-align: center;
  padding: 20px;
  background-color: #e0f7fa; /* Bleu pastel clair */
  min-height: 100vh;
}

.timer {
  font-size: 1.5rem;
  font-weight: bold;
  color: #d32f2f;
  margin-bottom: 10px;
}

.enigme-zone {
  position: relative;
  display: inline-block;
  margin-bottom: 20px; /* Espacement sous l'image */
}

.enigme-image-container {
  position: relative;
  display: inline-block;
}

.enigme-image {
  width: 800px; /* Agrandir l'image pour qu'elle soit plus grande */
  height: auto;
  border: 2px solid #ddd;
  border-radius: 8px;
}

.point-interrogation {
  position: absolute;
  font-size: 3rem; /* Agrandir les points d'interrogation */
  color: red;
  cursor: pointer;
}

.enigme-container {
  background: rgba(255, 255, 255, 0.8);
  padding: 20px;
  border-radius: 10px;
  margin-top: 20px;
  display: inline-block;
  width: 80%; /* Limiter la largeur */
  text-align: left;
}

.reponse-input {
  padding: 10px;
  margin-top: 10px;
  width: 100%;
  max-width: 400px; /* Limiter la taille du champ de réponse */
}

.validate-button {
  background-color: green;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  margin-top: 10px;
}

.feedback-message {
  margin-top: 10px;
  color: red;
}

.next-room-button {
  background-color: #2196f3;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}

.next-room-button:hover {
  background-color: #1976d2;
}
</style>
