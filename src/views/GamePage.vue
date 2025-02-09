<template>
  <div class="game-page">
    <h1 class="title">Choisissez votre Escape Game</h1>

    <div class="game-container">
      <div
        v-for="game in games"
        :key="game.id"
        class="game-bubble"
        :style="{ backgroundImage: `url(${game.image})` }"
      >
        <router-link :to="game.path" class="game-link">
          <div class="overlay">
            <h2>{{ game.title }}</h2>
            <p>{{ game.description }}</p>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import bibliothequeImage from "@/assets/victor_hugo1.jpg";
import voyageImage from "@/assets/voyage-temps.jpg";
import policeImage from "@/assets/enquete.jpg";

export default {
  name: "GamePage",
  data() {
    return {
      games: [
        {
          id: 1,
          title: "Voyage Mystérieux",
          description: "Explorez des mondes inconnus.",
          path: "/room1",
          image: voyageImage,
        },
        {
          id: 2,
          title: "Enquête Palpitante",
          description: "Résolvez un mystère captivant.",
          path: "/room2",
          image: policeImage,
        },
        {
          id: 3,
          title: "Bibliothèque Enchantée",
          description: "Découvrez les secrets des livres anciens.",
          path: "/room3",
          image: bibliothequeImage,
        },
      ],
    };
  },
};
</script>

<style scoped>
/* Fond général avec une image de fond */
.game-page {
  background: url("@/assets/escape2.jfif") no-repeat center center fixed;
  background-size: cover;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 20px;
}

.title {
  font-size: 2.5rem;
  color: #fff;
  margin-bottom: 2rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.game-container {
  display: flex;
  gap: 2rem;
  justify-content: center;
  flex-wrap: wrap;
}

.game-bubble {
  width: 220px;
  height: 220px;
  background-size: cover;
  background-position: center;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
  transition: transform 0.3s ease-in-out;
}

.game-bubble:hover {
  transform: scale(1.1);
}

.overlay {
  background: rgba(0, 0, 0, 0.7);
  color: white;
  text-align: center;
  padding: 20px;
  border-radius: 50%;
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.game-bubble:hover .overlay {
  opacity: 1;
}

.game-link {
  text-decoration: none;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
