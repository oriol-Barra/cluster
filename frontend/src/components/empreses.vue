<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section v-if="!empresaSeleccionada" class="empresas-section">
    <h2 class="section-title">Les Empreses del clúster</h2>
    <div v-if="empreses && empreses.length" class="empresas-grid">
      <div
        class="empresa-card"
        v-for="empresa in empreses"
        :key="empresa.id"
      >
        <h3 class="empresa-nombre">{{ empresa.nom }}</h3>
        <p class="empresa-direccion">{{ empresa.direcció }}</p>
        <button class="view-products-btn" @click="mostrarProductes(empresa)">
          Veure empresa
        </button>
      </div>
    </div>
    <p v-else class="no-empresas-message">No tens empreses registrades.</p>
  </section>

  <section v-if="empresaSeleccionada" class="productos-section">
    <button class="back-to-list-btn" @click="volverALista">
      Tornar a llista
    </button>
    <div class="empresa-card">
    <h3 class="empresa-nombre">{{ empresaSeleccionada.nom }}</h3>
    <p class="empresa-direccion">{{ empresaSeleccionada.direcció }}</p>
    <p class="empresa-descripcio">{{ empresaSeleccionada.descripcio }}</p>
    </div>
    <h3 class="section-title">Productes de {{ empresaSeleccionada?.nom || 'Empresa'}}</h3>
    <div v-if="productesSeleccionats && productesSeleccionats.length" class="productos-grid">
      <div class="producto-card" v-for="producte in productesSeleccionats" :key="producte.id">
        <h4 class="producto-nombre">{{ producte.nom }}</h4>
        <p class="producto-tipus">{{ producte.tipus }}</p>
        <p class="producto-precio">{{ producte.preu }}</p>
        <p class="producto-descripció">{{ producte.descripcio }}</p>
      </div>
    </div>
    <p v-else class="sin-productos">Aquesta empresa encara no té productes.</p>
  </section>
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

    async getEmpreses() {
      const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
      const response = await axios.get(`${baseURL}/api/empreses`);
      this.empreses = response.data.empreses;
      console.log(this.empreses);
    },

    async mostrarProductes(empresa) {
      try {
        const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
        const response = await axios.post(`${baseURL}/api/productes-per-empresa`, {
          empresa: empresa.nom || empresa.ciff,
        });

        if (response.status === 200) {
          const array = response.data.productes_elaborats;
          array.forEach(producte => {
            if (producte.descripcio) {
              producte.descripcio = this.sanitizeHtml(producte.descripcio);
            }
          });

          this.empresaSeleccionada = empresa;
          this.productesSeleccionats = array;
        }
      } catch (error) {
        const errorMessage = error.response?.data?.error || 'Error inesperat';
        alert(`Hi ha hagut un error: ${errorMessage}`);
        console.log(error);
      }
    },

    volverALista() {
      this.empresaSeleccionada = null;
      this.productesSeleccionats = [];
    },
  },
  mounted() {
    this.getEmpreses();
  },
};
</script>

<style scoped>
.empresas-section,
.productos-section {
  margin-bottom: 30px;
}
.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 20px;
  color: #4a4a8e;
}
.empresas-grid {
  display: block; /* Cambiar de grid a bloque */
}

.empresa-card {
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  margin-bottom: 15px;
  margin-right: 200px; /* Agregar margen derecho */
  margin-left:200px;
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

.sin-productos {
  font-size: 1rem;
  color: #6b7280;
  text-align: center;
  margin-top: 20px;
}

.back-to-list-btn {
  background-color: #6c757d;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  font-size: 0.9rem;
  cursor: pointer;
  margin-bottom: 20px;
  display: block;
}

.back-to-list-btn:hover {
  background-color: #495057;
}
</style>
