<template>
  <div class="login-container">
    <h1>Connexion</h1>
    <form @submit.prevent="handleLogin">
      <input
        type="email"
        v-model="email"
        placeholder="Adresse e-mail"
        required
      />
      <input
        type="password"
        v-model="password"
        placeholder="Mot de passe"
        required
      />
      <button type="submit" :disabled="isLoading">
        {{ isLoading ? "Connexion en cours..." : "Se connecter" }}
      </button>
    </form>
    <p v-if="message" :class="messageClass">{{ message }}</p>
  </div>
</template>

<script>
export default {
  name: "LoginPage",
  data() {
    return {
      email: "",
      password: "",
      message: "",
      messageClass: "",
      isLoading: false, // Indicateur de chargement
    };
  },
  methods: {
    async handleLogin() {
      this.isLoading = true;
      this.message = "";
      try {
        const response = await fetch(
          "http://localhost/mini-escape-game/backend/api.php?action=login", // Remplace avec l'URL de ton API pour la connexion
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              email: this.email,
              password: this.password,
            }),
          }
        );

        const responseText = await response.text();
        console.log("Réponse brute du serveur:", responseText);

        if (!response.ok) {
          throw new Error(`Erreur lors de la connexion : ${response.status}`);
        }

        const data = JSON.parse(responseText);

        if (data.success) {
          this.message = data.message || "Connexion réussie !";
          this.messageClass = "success";

          // Redirection vers GameRoom.vue après une connexion réussie
          this.$router.push("/game-room");
        } else {
          this.message = data.error || "Une erreur est survenue.";
          this.messageClass = "error";
        }
      } catch (error) {
        console.error("Erreur lors de la connexion :", error);
        this.message = "Une erreur est survenue. Veuillez réessayer.";
        this.messageClass = "error";
      } finally {
        this.isLoading = false; // Arrête l'indicateur de chargement
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 100px auto;
  text-align: center;
}

input {
  display: block;
  width: 100%;
  padding: 10px;
  margin: 10px 0;
}

button {
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}

p {
  font-size: 1.1rem;
  margin-top: 20px;
}

.success {
  color: #28a745;
}

.error {
  color: #dc3545;
}
</style>
