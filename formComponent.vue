<template>
    <form action="#" class="form newtopic">
      <div class="row">
            <div class="form-group">
              <label>Full Name</label>
              <input v-model="form.fname" type="text" placeholder="Full Name" class="form-control" :class="{ 'is-invalid': v.$error }" name="fname">
              <div v-if="!v.required">Full name is required</div>
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input v-model="form.phone" type="tel" placeholder="Phone Number" class="form-control" :class="{ 'is-invalid': v.$error }" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
              <div v-if="!v.required">Phone number is required</div>
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input v-model="form.email" type="email" placeholder="Email Address" class="form-control" :class="{ 'is-invalid': v.$error }" name="email">
              <div v-if="!v.required">Email is required</div>
            </div>
            <div class="form-group">
              <label>ID</label>
              <input v-model="form.idnumber" type="number" placeholder="ID" class="form-control" :class="{ 'is-invalid': v.$error }" name="idnumber" pattern="\d*" maxlength="9">
              <div v-if="!v.required">ID is required</div>
            </div>
          <button type="button" @click="submitUserDetails" class="btn btn-primary">Submit</button>
        </div>
    </form>
  <div v-if="error">
    {{ error }}
  </div>
</template>


<script>
export default {
  data () {
    return {
      form: {
        fname: '',
        phone: '',
        email: '',
        idnumber: '',
      },
      errors: null,
      sumOfPremia: '',
      hbjson: [],
    }
  },
  validations: {
    form: {
      fname: { required },
      phone: { required },
      email: { required, email },
      idnumber: { required }
    }
  },
  methods: {
    submitUserDetails() {
      fetch('https://ibell.frb.io/api/test/getJson', {
        method: 'post',
        body: JSON.stringify(this.form),
        headers: {
          'content-type': 'application/json'
        }
      })
          .then(response => response.json())
          .then(data => {
            if(data.status === "failure") {
              this.error = data.errmsg;
            } else {
              this.hbjson = data;
              if(this.calcSumOfPremia() > 50) {
                this.postPremia("https://ibell.frb.io/zapier/add/lead/31198");
              } else {
                this.postPremia("https://ibell.frb.io/zapier/add/lead/38754");
              }
            }
          })
          .catch(err => this.error = err);
    },

    calcSumOfPremia() {
      return this.hbjson
          .map(x => parseInt(x.premia))
          .reduce((y, z) => y + z);
    },

    postPremia(url) {
      new Request(url,
          {
            method: "POST",
            body: JSON.stringify(this.form),
            mode: "cors",
            cache: "default"
          }
      );
    }
  }
}
</script>
