<template>
  <div>

<h3>Добавить метод оплаты</h3>
    <div class="card-body">

        <div class="alert alert-danger" v-if="feedback">
            <ul>
                <li v-for="error in feedback">{{ error[0] }}</li>
            </ul>
        </div>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" v-model="title" v-validate="{ required: true, min: 3, max: 100 }" name="title" class="form-control" :class="{ 'is-invalid': submitted && errors.has('title') }" />
                <div v-if="submitted && errors.has('title')" class="invalid-feedback">{{ errors.first('title') }}</div>
            </div>
            <div class="form-group">
                <button class="btn btn-info">Add Payment Method</button>
            </div>
        </form>
    </div>

<br>

<h3>Таблица методов оплаты</h3>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">title</th>
      <!-- <th scope="col">show</th> -->
      <th scope="col">delete</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="paymentmethod in paymentmethods">
      <th>{{ paymentmethod.id }}</th>
      <td>{{ paymentmethod.title }}</td>
      <!-- <td><a href="#" @click="showPaymentMethod(paymentmethod.id)">Show</a></td> -->
      <td><a href="#" @click="deletePaymentMethod(paymentmethod.id)">Delete</a></td>
    </tr>
  </tbody>
</table>

  </div>
</template>

<script>
import axios from 'axios' 
import { mapActions, mapGetters } from 'vuex'

  export default {
      name: 'crudpaymentmethods',
      data() {
          return {
             title: '',
             feedback: '',
             submitted: false,
        }
      },
      mounted: function () {
        this.$store.dispatch('LOAD_PAYMENTMETHODS')
      },
      computed: {
          ...mapGetters({
          paymentmethods: 'GET_PAYMENTMETHODS',
        })
      },
      methods: {
           handleSubmit(e) {
            this.submitted = true;
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.addPaymentMethod()
                }
            });
          },
          addPaymentMethod() {
              axios.post('/api/paymentmethods', { 
                  title: this.title, 
                  })                    
                  .then(function (response) {
                        alert(response.data.message)
                  })
                  .catch(error => {
                      this.feedback = error.response.data.errors;
                  });
                  this.$store.dispatch('LOAD_PAYMENTMETHODS')
                  this.feedback = null
          },
        //   showPaymentMethod(id) {       
        //         axios.get('/api/paymentmethods/' + id)
        //               .then(response => {
        //            alert('Вот твоя строчка номер ' + id + ' (я пришел с клиента) (Влад, исправь меня, я не так передаю данные)'); 
        //            this.paymentmethods = this.paymentmethods.filter(paymentmethod => {
        //             return paymentmethod.id == id;
        //          });
        //         })
        //   },

          deletePaymentMethod(id) {
                axios.delete('/api/paymentmethods/' + id)
                    .then(function (response) {
                        alert(response.data.message);
                    });
                this.$store.dispatch('LOAD_PAYMENTMETHODS')
          }
      },
  }
</script>