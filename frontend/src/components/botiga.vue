<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="productos-section">
    <h2 class="section-title">La Botiga del clúster</h2>
    <div v-if="productes && productes.length" class="productos-list">
      <div class="producto-item" v-for="producte in productes" :key="producte.id">
        <div class="producto-info">
          <h3 class="producto-nombre">{{ producte.nom }}</h3>
          <p class="producto-preu">preu sense iva:{{ producte.preu }} €</p>
          <p class="producto-preu">{{ producte.descripcio }} </p>
          <p class="producto-preu">preu total:{{ producte.preu_total }} €</p>
          <img v-if="producte.foto" :src="getFotoUrl(producte.foto)" alt="Foto del producte" />
          <p v-else>No hi ha imatge disponible</p>
        </div>
        <button class="add-to-cart-btn" @click="afegirAlCarro(producte)">
          Afegir al carro
        </button>
      </div>
    </div>
    <p v-else class="no-productos-message">No tens productes registrats.</p>

    <!-- Carro de la compra -->
    <div class="carro-section">
      <h3 class="section-title">Carro de la Compra</h3>
      <ul v-if="carro.length">
        <li v-for="item in carro" :key="item.id">
          {{ item.nom }} - Quantitat: {{ item.quantity }} - Total: {{ (item.preu_total * item.quantity).toFixed(2) }} €
          <button @click="eliminarDelCarro(item.product_id)">Eliminar</button>
        </li>
      </ul>
      <p v-else>El carro està buit.</p>
      <button v-if="carro.length" @click="enviarCarro" class="finalizar-btn">Finalitzar compra</button>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default{
    // eslint-disable-next-line vue/multi-word-component-names
    name:'botiga',
    data(){
      return{
        productes:[],
        carro:[],
      };
    },

  mounted(){
    this.getAllProductes();
    this.carro = JSON.parse(localStorage.getItem('carro')) || [];

  },

  methods:{
      getFotoUrl(foto) {
        return foto ? `http://localhost:8088/storage/${foto}` : "";
      },
      
      sanitizeHtml(html) {
          return html.replace(/<\/?[^>]+(>|$)/g, ""); // Eliminar todas las etiquetas HTML
        },

      async getAllProductes(){
          try {
              const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
              const response = await axios.get(`${baseURL}/api/productes`);
              if (response.status === 200) {
                const array = response.data.productes
                array.forEach(producte => {
                  if (producte.descripcio) {
                    producte.descripcio = this.sanitizeHtml(producte.descripcio);
                  }
                });
                this.productes=array;
                console.log(array)

              }
            } catch (error) {
              console.error('Error carregant productes:', error);
              alert('No s\'han pogut carregar els productes.');
            }
        },

        //funció per afegir productes al carro
        afegirAlCarro(producte){

            const index=this.carro.findIndex((item)=>item.product_id===producte.id);
            if(index!==-1){
              //si aquest producte ja està al carro sumar una unitat
              this.carro[index].quantity++;
            }else{
              //si aquest producte no està al carro l'afegim:
              this.carro.push({
                product_id:producte.id,
                preu_total:producte.preu_total,
                quantity:1});
            }
            localStorage.setItem('carro', JSON.stringify(this.carro));
            console.log(this.carro);
        },

        // Eliminar producto del carro
        eliminarDelCarro(productId) {
           this.carro = this.carro.filter((item) => item.product_id !== productId);
           localStorage.setItem('carro',JSON.stringify(this.carro));
        },

        //enviar el carro al backend:
        async enviarCarro(){
              try{
              const baseURL = process.env.VUE_APP_API_BASE_URL || "http://localhost:8088";
              const token=localStorage.getItem('authToken');
              const response=await axios.post(
                `${baseURL}/api/checkout`,
                {carro:this.carro},
                {
                  headers:{
                    Authorization: `Bearer ${token}`,
                  },
                }
              );
              if(response.status===201){
                alert("Comanda creada amb èxit!");
                this.carro = []; // Vaciar el carro después de finalizar la compra
              }

            }catch (error) {
            console.error("Error enviant el carro:",error.response.data );
            alert("No s'ha pogut finalitzar la compra.");
          }
      }
    }

  };

</script>
<style scoped>
/* Estilos generales */


.section-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
  text-align: center;
}

/* Lista de productos */
.productos-list {
  display: flex;
  flex-direction: column; /* Lista vertical */
  gap: 15px;
  align-items: center; /* Alinear al lado izquierdo */
}

/* Item de producto */
.producto-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 600px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Información del producto */
.producto-info {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.producto-nombre {
  font-size: 18px;
  font-weight: bold;
}

.producto-preu {
  font-size: 16px;
  color: #555;
}

/* Botón de agregar al carro */
.add-to-cart-btn {
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-to-cart-btn:hover {
  background-color: #218838;
}

/* Mensaje de no productos */
.no-productos-message {
  font-size: 16px;
  color: #666;
  text-align: center;
  margin-top: 20px;
}
.carro-section {
  margin-top: 30px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #f9f9f9;
}
.finalizar-btn {
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.finalizar-btn:hover {
  background-color: #0056b3;
}
</style>