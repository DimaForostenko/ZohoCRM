<template>
  <div class="form-container">
    <h1>Create Deal and Account</h1>
    <form @submit.prevent="submitForm">
      <!-- Deal fields -->
      <div>
        <label for="dealName">Deal Name:</label>
        <input v-model="form.dealName" id="dealName" required />
      </div>
      <div>
        <label for="dealStage">Deal Stage:</label>
        <input v-model="form.dealStage" id="dealStage" required />
      </div>

      <!-- Account fields -->
      <div>
        <label for="accountName">Account Name:</label>
        <input v-model="form.accountName" id="accountName" required />
      </div>
      <div>
        <label for="accountWebsite">Account Website:</label>
        <input v-model="form.accountWebsite" id="accountWebsite" required />
      </div>
      <div>
        <label for="accountPhone">Account Phone:</label>
        <input v-model="form.accountPhone" id="accountPhone" required />
      </div>

      <!-- Submit -->
      <button type="submit">Submit</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    <p v-if="successMessage" class="success">{{ successMessage }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        dealName: "",
        dealStage: "",
        accountName: "",
        accountWebsite: "",
        accountPhone: "",
      },
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    async submitForm() {
      try {
        const response = await axios.post("/api/zoho/create", this.form);
        this.successMessage = "Records created successfully!";
        this.errorMessage = "";
      } catch (error) {
        this.errorMessage = error.response.data.message || "An error occurred.";
        this.successMessage = "";
      }
    },
  },
};
</script>
