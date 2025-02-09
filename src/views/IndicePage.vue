<template>
  <div class="hint-container">
    <h1>Indices</h1>

    <!-- Si aucun indice n'est disponible -->
    <p v-if="hints.length === 0">Aucun indice disponible pour le moment.</p>

    <!-- Affichage des indices -->
    <ul v-else>
      <li v-for="(hint, index) in hints" :key="index">{{ hint }}</li>
    </ul>

    <!-- Bouton pour fermer les indices -->
    <button @click="closeHints">Fermer</button>
  </div>
</template>

<script>
export default {
  name: "IndicePage",
  data() {
    return {
      hints: [], // Liste des indices vide au départ
      errorMessage: "", // Pour les erreurs d'API
    };
  },
  mounted() {
    this.loadHints(); // Appel de la méthode pour charger les indices
  },
  methods: {
    // Méthode pour récupérer les indices depuis le backend
    async loadHints() {
      try {
        const response = await fetch(
          "http://localhost/mini-escape-game/backend/api.php?action=indice",
          {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          }
        );

        if (!response.ok) {
          throw new Error("Impossible de charger les indices.");
        }

        const data = await response.json();
        this.hints = data.hints || []; // Mise à jour de la liste des indices
      } catch (error) {
        console.error("Erreur lors du chargement des indices :", error);
        this.errorMessage =
          "Erreur lors du chargement des indices. Veuillez réessayer plus tard.";
      }
    },

    // Méthode pour fermer les indices et revenir au jeu
    closeHints() {
      this.$router.push("/game");
    },
  },
};
</script>

<style scoped>
/* Style général pour la page des indices */
.hint-container {
  text-align: center;
  padding: 20px;
  background: #f4f4f9;
}

/* Titre de la page */
h1 {
  color: #0875e2;
  font-size: 2.5rem;
}

/* Style de la liste des indices */
ul {
  list-style: none;
  padding: 0;
}

li {
  font-size: 1.2rem;
  margin-bottom: 10px;
}

/* Style du bouton */
button {
  margin-top: 20px;
  padding: 10px 20px;
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

/* Message d'erreur */
.error-message {
  color: red;
  font-size: 1rem;
  margin-top: 20px;
}
</style>
