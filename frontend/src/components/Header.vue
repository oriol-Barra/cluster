<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <header class="header-container">
    <nav class="nav-container">
      <!-- Icono a la izquierda -->
      <div class="left-section">
        <img src="@/assets/logocluster.png" alt="Logo" class="logo-icon" />
      </div>

      <div class="center-buttons">
        <router-link to="/">
          <button class="nav-button">Inici</button>
        </router-link>
        <router-link to="/botiga">
          <button class="nav-button">Botiga</button>
        </router-link>
        <router-link to="/empreses">
          <button class="nav-button">Empreses</button>
        </router-link>
        <router-link to="/qui-som">
          <button class="nav-button">Qui Som</button>
        </router-link>
      </div>

    <!-- Opciones para usuarios no autenticados -->
      <div class="right-section">
        <router-link v-if="!isAuthenticated" to="/register">
          <button class="auth-button">Registre</button>
        </router-link>
        <router-link v-if="!isAuthenticated" to="/login">
          <button class="auth-button">Login</button>
        </router-link>

        <!-- Menú desplegable para usuarios autenticados -->
        <div v-if="isAuthenticated" class="dropdown" @mouseleave="toggleMenu(false)">
          <button class="auth-button" @mouseenter="toggleMenu(true)">
            Menú
          </button>
          <div v-if="menuOpen" class="dropdown-menu">
                    
            <!-- Menú per a clients -->
            <router-link v-if="rol === 'client'" to="/dashboard">
              <button class="dropdown-item">Menú personal</button>
            </router-link>
            <router-link v-if="rol === 'client'" to="/carrito">
              <button class="dropdown-item">Carrito</button>
            </router-link>
            <router-link v-if="rol === 'admin'"  to="/dashboard">
              <button class="dropdown-item">Menú personal</button>
            </router-link>
            <router-link v-if="rol === 'admin'"  to="/empreses">
              <button class="dropdown-item">empreses</button>
            </router-link>
            <router-link v-if="rol === 'admin'"  to="/novaEmpresa">
              <button class="dropdown-item">nova empresa</button>
            </router-link>
            <router-link v-if="rol === 'admin'" to="/EditaEmpresa">
              <button class="dropdown-item">edita empresa</button>
            </router-link>
            <router-link v-if="rol === 'admin'" to="/NouProducte">
              <button class="dropdown-item">Nou porducte</button>
            </router-link>
            <router-link v-if="rol === 'admin'" to="/editaProducte">
              <button class="dropdown-item">edita producte</button>
            </router-link>
            <button
              class="dropdown-item logout-button"
              @click="logout"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
  import axios from 'axios';
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Header",
  data() {
    return {
      isAuthenticated: false, // Determina si el usuario está autenticado
      menuOpen: false, // Controla si el menú está abierto
      rol:'',
    };
  },
  mounted() {
    this.checkAuthentication();
  },
  watch: {
    // Este watcher se dispara cuando cambia el localStorage
    '$route'() {
      this.checkAuthentication();
    },
  },
  methods: {
    async checkAuthentication() {
      const token = localStorage.getItem("authToken");
      this.isAuthenticated = !!token;
      if(token){
        try{
          const response = await axios.get('http://localhost:8088/api/usuari/detalls', {
          headers: {
            Authorization: `Bearer ${token}`, // Enviar el token en el encabezado
          },
        });
        console.log(response);
        this.rol = response.data.user.rol;

       }catch(error){
        console.error("Error obteniendo los detalles del usuario:", error);
        this.logout();
      }
    }
    },
    toggleMenu(state) {
      this.menuOpen = state; // Abre o cierra el menú
    },
    async logout() {
      const token = localStorage.getItem('authToken') // Obtenir el token del localStorage
      const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
       await axios.post(`${baseURL}/api/logout`,{},
       {
       headers: {
          Authorization: `Bearer ${token}`, // Enviar el token en el encabezado
        },
      })
      this.isAuthenticated = false;
      this.menuOpen = false;
      localStorage.clear();
      this.$router.push("/login");
    },
    
  },
  
};
</script>

<style>
/* General Header Styles */
.header-container {
  width: 100%;
  padding: 30px 40px;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

/* Logo Icon */
.logo-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  object-fit: cover;
}

/* Buttons */
.nav-button,
.auth-button {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 12px 25px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.nav-button:hover,
.auth-button:hover {
  background-color: #0056b3;
}

/* Dropdown Menu Styles */
.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  right: 0;
  top: 100%;
  background: white;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 10;
  width: 200px;
}

.dropdown-item {
  display: block;
  width: 100%;
  padding: 10px 15px;
  text-align: left;
  background: white;
  border: none;
  color: #333;
  cursor: pointer;
  transition: background 0.3s ease;
}

.dropdown-item:hover {
  background: #f5f5f5;
}

.logout-button {
  color: red;
}

.logout-button:hover {
  background: #fee;
}
.right-section {
  display: flex;
  align-items: center;
  gap: 15px; /* Aumenta el espacio entre los botones */
}
.center-buttons {
  display: flex;
  justify-content: center;
  gap: 30px; /* Incrementa el espacio entre los botones */
  flex: 1;
}
</style>
