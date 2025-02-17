<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="dashboard">
    <header class="header">
      <h1 class="welcome-message">Benvingut, {{ user.nom }} {{ user.cognoms }}</h1>
      <p class="user-email">{{ user.email }}</p>
    </header>

    <section class="empresas-section">
      <h2 class="section-title">Les teves Empreses</h2>
      <div v-if="empreses && empreses.length" class="empresas-grid">
        <div
          class="empresa-card"
          v-for="empresa in empreses"
          :key="empresa.id"
        >
          <h3 class="empresa-nombre">{{ empresa.nom }}</h3>
          <p class="empresa-direccion">{{ empresa.direcció }}</p>
          <button class="view-products-btn" @click="mostrarProductes(empresa)"
          >Veure productes</button>
        </div>
      </div>
      <p v-else class="no-empresas-message">No tens empreses registrades.</p>
    </section>

    <section v-if="empresaSeleccionada" class="productos-section">
      <h3 class="section-title">Productes de {{ empresaSeleccionada?.nom || 'Empresa'}}</h3>
      <div v-if="productesSeleccionats && productesSeleccionats.length" class="productos-grid">
        <div class="producto-card" v-for="producte in productesSeleccionats" :key="producte.id">
          <h4 class="producto-nombre">{{ producte.nom }}</h4>
          <p class="producto-tipus">{{ producte.tipus }}</p>
          <p class="producto-precio">{{ producte.preu }}</p>
          <p class="producto-descripció">{{producte.descripcio}}</p>
        </div>
      </div>
      <p v-else class="sin-productos">Aquesta empresa encara no té productes.</p>
    </section>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: {
        nom: '',
        cognoms: '',
        email: '',
      },
      empreses: [],
      productesSeleccionats: [],
      empresaSeleccionada: null,
    };
  },
  methods: {
    sanitizeHtml(html) {
      return html.replace(/<\/?[^>]+(>|$)/g, ""); // Eliminar todas las etiquetas HTML
    },
    async fetchDadesUsuari() {
      try {
        const token = localStorage.getItem('authToken');
        const response = await axios.get('http://localhost:8088/api/usuari/detalls', {
          headers: {
            Authorization: `Bearer ${token}`, // Enviar el token en el encabezado
          },
        });

        this.user = response.data.user;
        this.empreses = response.data.empreses;
      } catch (error) {
        console.error('Error al carregar les dades del usuari:', error);
        alert('No s han pogut carregar les dades.');
      }
    },
    async mostrarProductes(empresa) {
      try {
          const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
          const response = await axios.post(`${baseURL}/api/productes-per-empresa`, {
            empresa: empresa.nom||empresa.ciff,
          });
          if (response.status === 200) {    
            console.log(response.data.productes_elaborats);
            const array=  response.data.productes_elaborats;  
            array.forEach(producte => {
              if(producte.descripcio){
              producte.descripcio=this.sanitizeHtml(producte.descripcio);
              }
            }); 
                
  
            this.empresaSeleccionada = response.data.empresa || null;
            this.productesSeleccionats = array;
          }
        } catch (error) {
          const errorMessage = error.response?.data?.error || 'Error inesperat';
          alert(`Hi ha hagut un error: ${errorMessage}`);
          console.log(error);
        }

    },
  },
  mounted() {
    this.fetchDadesUsuari();
  },
};
</script>

<style scoped>
.dashboard {
  padding: 20px;
  font-family: 'Arial', sans-serif;
  color: #333;
  min-height: 100vh;
}

.header {
  text-align: center;
  margin-bottom: 30px;
}

.welcome-message {
  font-size: 2rem;
  font-weight: bold;
  color: #4a4a8e;
}

.user-email {
  font-size: 1rem;
  color: #6b7280;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 20px;
  color: #4a4a8e;
}

.empresas-section,
.productos-section {
  margin-bottom: 30px;
}

.empresas-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.empresa-card {
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.empresa-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.empresa-nombre {
  font-size: 1.2rem;
  font-weight: bold;
  color: #111827;
  margin-bottom: 10px;
}

.empresa-direccion {
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 10px;
}

.view-products-btn {
  background-color: #007bff;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.view-products-btn:hover {
  background-color: #3b3b6e;
}

.productos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 15px;
}

.producto-card {
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
}

.producto-nombre {
  font-size: 1rem;
  font-weight: bold;
  color: #111827;
}

.producto-precio {
  font-size: 0.9rem;
  color: #4a4a8e;
}

.no-empresas-message {
  font-size: 1rem;
  color: #6b7280;
  text-align: center;
  margin-top: 20px;
}
</style>
