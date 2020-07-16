<template>
  <div id="crud" class="row">
    <div class="col-xs-12">
      <h1 class="page-header">Crud Laravel y VUEjs</h1>
    </div>
    <div class="col-sm-7">
      <a
        href="#"
        id="modalAdd"
        class="btn btn-warning btn-sm"
        @click="options('product', 'create')"
      >
        <i class="far fa-add"></i>Add
      </a>
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(task, i) in arraysProducts" :key="i">
            <td width="10px">{{ task.id }}</td>
            <td>{{ task.name }}</td>
            <td width="10px">
              <a
                href="#"
                id="modalAdd"
                class="btn btn-warning btn-sm"
                @click="options('product', 'edit',task)"
              >
                <i class="far fa-edit"></i>Edit
              </a>
            </td>
            <td width="10px">
              <a
                href="#"
                id="modalAdd"
                class="btn btn-warning btn-sm"
                @click="options('product', 'delete',task)"
              >
                <i class="far fa-minas"></i>Delete
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <b-modal ref="my-modal">
      <template slot="modal-title">{{ titlemodal }}</template>

      <form ref="form">
        <b-form-group label="Name" label-for="name-input">
          <b-form-input id="name-input" name="name-input" v-model="name" required></b-form-input>
        </b-form-group>
      </form>

      <template v-slot:modal-footer="{ cancel }">
        <b-button
          id="btn_update"
          style="display: none"
          size="sm"
          variant="success"
          @click="update()"
        >Update</b-button>
        <b-button
          id="btn_create"
          style="display: none"
          size="sm"
          variant="success"
          @click="create()"
        >Create</b-button>
        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
      </template>
    </b-modal>
  </div>
</template>


<script>
import { BootstrapVue } from "bootstrap-vue";
Vue.use(BootstrapVue);

export default {
  //   components: {
  //     BootstrapVue//
  //   },
  data() {
    return {
      arraysProducts: [],
      titlemodal: "",
      result: "",
      name: "",
      id: 0
    };
  },
  computed: {},
  methods: {
    async options(modelo, accion, data = []) {
      switch (modelo) {
        case "product": {
          let me = this;
          switch (accion) {
            case "edit": {
              setTimeout(() => {
                document.getElementById("btn_update").style.display = "block";
              }, 100);
              setTimeout(() => {
                document.getElementById("btn_create").style.display = "none";
              }, 100);
              me.titlemodal = "Edit Name";
              me.id = data.id;
              me.name = data.name;
              this.$refs["my-modal"].show();

              break;
            }
            case "delete": {
              me.delete(data);
              break;
            }
            case "create": {
              setTimeout(() => {
                document.getElementById("btn_create").style.display = "block";
              }, 100);
              setTimeout(() => {
                document.getElementById("btn_update").style.display = "none";
              }, 100);
              me.titlemodal = "Create Name";
              me.name = "";
              this.$refs["my-modal"].show();
              break;
            }
          }
        }
      }
    },

    async read() {
	/*
      let me = this;
      try {
        const result_1 = await window.axios.get("/list_product");
        const result_2 = await result_1.data;
        const arrays = await result_2.result;
        me.arraysProducts = arrays;
        if (result_1.status !== 200) throw Error("No hay Lista de Products");
      } catch (e) {
        console.log(`Error: ${e}`);
      }
	*/
      let me = this;
      const result_ = await window.axios
        .get("/list_product")
        .then(function(response) {
          let respuesta = response.data;
          me.arraysProducts = respuesta.result;
        })
        .catch(function(error) {
          console.log(error);
        });
      this.result = result_;
    },

    async create() {
      let me = this;
      let post = { name: document.querySelector("#name-input").value };
      const result_ = await window.axios
        .post("/create_product", post)
        .then(function(response) {
          me.read();
        })
        .catch(function(error) {
          console.log(error);
        });
      this.result = result_;
    },
    async update() {
      let me = this;
      let post = {
        name: document.querySelector("#name-input").value,
        id: me.id
      };
      const result_ = await window.axios
        .post("/update_product", post)
        .then(function(response) {
          me.read();
        })
        .catch(function(error) {
          console.log(error);
        });
      this.result = result_;
    },

    async delete(data) {
      let me = this;
      let post = { id: data.id };
      const result_ = await window.axios
        .post("/delete_product", post)
        .then(function(response) {
          me.read();
        })
        .catch(function(error) {
          console.log(error);
        });

      this.result = result_;
    }
  },
  mounted() {
    this.read();
  }
};
</script>