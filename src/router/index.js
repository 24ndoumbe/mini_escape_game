import { createRouter, createWebHistory } from "vue-router";

// Importer les pages nécessaires
import HomePage from "@/views/HomePage.vue";
import Room1Page from "@/views/Room1Page.vue";
import Room2Page from "@/views/Room2Page.vue";
import Room3Page from "@/views/Room3Page.vue";
import LoginPage from "@/views/LoginPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";
import GamePage from "@/views/GamePage.vue";
import ResultsPage from "@/views/ResultsPage.vue";
import InventairePage from "@/views/InventairePage.vue"; // Page de l'inventaire
import IndicePage from "@/views/IndicePage.vue"; // Ajouter la page des indices

// Définir les routes
const routes = [
  {
    path: "/",
    name: "Home",
    component: HomePage,
  },
  {
    path: "/room1",
    name: "Room1",
    component: Room1Page,
  },
  {
    path: "/room2",
    name: "Room2",
    component: Room2Page,
  },
  {
    path: "/room3", // Ajout pour Room3
    name: "Room3",
    component: Room3Page,
  },
  {
    path: "/login",
    name: "Login",
    component: LoginPage,
  },
  {
    path: "/register",
    name: "Register",
    component: RegisterPage,
  },
  {
    path: "/game",
    name: "Game",
    component: GamePage,
  },
  {
    path: "/results",
    name: "Results",
    component: ResultsPage,
  },
  {
    path: "/inventaire", // Nouvelle route pour l'inventaire
    name: "Inventaire",
    component: InventairePage,
  },
  {
    path: "/indice", // Nouvelle route pour les indices
    name: "Indice",
    component: IndicePage, // Composant HintPage pour afficher les indices
  },
];

// Créer le router
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
