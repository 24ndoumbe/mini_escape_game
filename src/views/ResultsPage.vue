<template>
  <div class="results-container">
    <h1>Résultats du Jeu</h1>
    <p v-if="loading">Chargement des résultats...</p>
    <p v-if="!loading && score !== null">
      Félicitations , vous avez terminé le jeu !
    </p>
    <p v-if="!loading && score !== null">
      Votre score final : <strong>{{ score }}</strong> points
    </p>

    <p v-if="!loading && score === 0">
      Désolé, vous avez perdu. Essayez encore une fois pour améliorer votre
      score !
    </p>

    <!-- Boutons de navigation -->
    <button @click="goToHome">Retour à l'accueil</button>
    <button @click="restartGame">Recommencer le jeu</button>
  </div>
</template>

<script>
export default {
  name: "ResultsPage",
  data() {
    return {
      score: null, // Score du joueur, récupéré depuis l'API
      loading: true,
    };
  },
  created() {
    this.fetchScore();
  },
  methods: {
    async fetchScore() {
      try {
        // Exemple fictif de requête GET à l'API pour récupérer le score
        const response = await fetch(
          "http://localhost/mini-escape-game/backend/api.php?action=resultats",
          {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          }
        );
        if (!response.ok) {
          throw new Error("Erreur lors de la récupération du score.");
        }
        const data = await response.json();
        this.score = data.score;
      } catch (error) {
        console.error("Erreur lors de la récupération du score :", error);
        this.score = 0; // Valeur par défaut en cas d'erreur
      } finally {
        this.loading = false;
      }
    },
    goToHome() {
      this.$router.push("/");
    },
    restartGame() {
      this.$router.push("/game");
    },
  },
};
</script>

<style scoped>
.results-container {
  text-align: center;
  padding: 20px;
  background-color: #f4f4f9;
  min-height: 100vh;
}

h1 {
  color: #3498db;
}

button {
  padding: 10px 20px;
  margin: 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #45a049;
}

button:active {
  background-color: #388e3c;
}
</style>
