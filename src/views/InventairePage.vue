<template>
  <div class="inventory-page">
    <h2>Mon Inventaire</h2>

    <!-- Affichage d'un message d'erreur si l'inventaire ne se charge pas -->
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

    <!-- Affichage de l'inventaire -->
    <ul v-if="inventory.length > 0">
      <li v-for="item in inventory" :key="item.inventaire_id">
        {{ item.objet_nom }} (Quantité: {{ item.quantite }})
      </li>
    </ul>

    <!-- Message si l'inventaire est vide -->
    <p v-else>Votre inventaire est vide.</p>
  </div>
</template>

<script>
export default {
  name: "InventairePage",
  data() {
    return {
      inventory: [],
      errorMessage: "", // Message d'erreur s'il y en a une
    };
  },
  mounted() {
    this.loadInventory();
  },
  methods: {
    async loadInventory() {
      try {
        const response = await fetch(
          "http://localhost/mini-escape-game/backend/api.php?action=inventory",
          {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          }
        );

        if (!response.ok) {
          throw new Error("Impossible de charger l'inventaire.");
        }

        const data = await response.json();
        this.inventory = data.inventory;
      } catch (error) {
        console.error("Erreur lors du chargement de l'inventaire :", error);
        this.errorMessage =
          "Erreur lors du chargement de l'inventaire. Veuillez réessayer plus tard.";
      }
    },
  },
};
</script>

<style scoped>
/* Style pour l'inventaire */
.inventory-page {
  background-color: rgba(0, 0, 0, 0.7);
  padding: 20px;
  border-radius: 10px;
  color: white;
  max-width: 600px;
  margin: 20px auto;
  text-align: center;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  font-size: 1.2rem;
  margin: 10px 0;
}

.error-message {
  color: #ff4d4d;
  font-size: 1.2rem;
  margin-top: 20px;
}
</style>
