<template>
    <div class="landing-page">
      <header>
        <h1 class="title">ClusterCraft Beer</h1>
        <p class="subtitle">El cluster català de la cervesa artesana</p>
      </header>
    </div>
  </template>
  
  <script>
  export default {
    name: "landingPage",
  };
  </script>
  
  <style scoped>
  .landing-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
    background: linear-gradient(to bottom, #f6d365, #fda085);
    font-family: 'Arial', sans-serif;
    color: #333;
  }
  
  .title {
    font-size: 3rem;
    font-weight: bold;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  }
  
  .subtitle {
    font-size: 1.5rem;
    margin-top: 1rem;
    color: #f8f8f8;
  }
  </style>
  