<template>
  <div id="app">
    <!-- Barre de navigation -->
    <nav class="navbar">
      <ul>
        <nav class="navbar">
          <ul>
            <li><router-link to="/">Accueil</router-link></li>
            <!-- <li><router-link to="/game">Jeu</router-link></li>
            <li><router-link to="/results">Résultats</router-link></li>-->
            <li><router-link to="/login">Connexion</router-link></li>
            <li><router-link to="/register">Inscription</router-link></li>
          </ul>
        </nav>
      </ul>
    </nav>

    <!-- Contenu de la page -->
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
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
/* Réinitialisation globale */
*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  margin: 0;
  padding: 0;
  font-family: "Arial", sans-serif;
  background-color: #f9f9f9;
}

/* Style de la barre de navigation */
.navbar {
  background-color: #333;
  padding: 15px 20px;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.navbar ul {
  list-style: none;
  display: flex;
  justify-content: center;
}

.navbar li {
  margin: 0 15px;
}

.navbar a {
  color: white;
  text-decoration: none;
  font-size: 1.2rem;
  font-weight: bold;
  transition: color 0.3s;
}

.navbar a:hover {
  color: #4caf50;
}

/* Style du contenu principal */
#app {
  padding-top: 70px; /* Compense la hauteur de la barre de navigation */
}

.router-view {
  padding: 20px;
}
</style>
