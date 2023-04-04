<template>
    <md-card class="product-selector-card">
        <md-card-header>
            <div class="md-title">Product Price</div>
        </md-card-header>
        <md-card-content>
            <span class="md-error" v-if="formErrors.form">{{ formErrors.form.join('; ') }}</span>
            <md-field :class="{'md-invalid': !!formErrors.productId}">
                <label for="movie">Choose a product</label>
                <md-select v-model="form.productId">
                    <md-option v-for="product in products" 
                            :key="product.id" 
                            :value="product.id">
                        {{ product.name }}
                    </md-option>
                </md-select>
                <span class="md-error" v-if="formErrors.productId">{{ formErrors.productId.join('; ') }}</span>
            </md-field>
            <md-field :class="{'md-invalid': !!formErrors.taxNumber}">
                <label>Your Taxpayer Number</label>
                <md-input v-model="form.taxNumber"></md-input>
                <span class="md-error" v-if="formErrors.taxNumber">{{ formErrors.taxNumber.join('; ') }}</span>
            </md-field>

            <div v-if="totalAmount" class="md-headline">
                Total amount is {{ totalAmount }} {{ totalAmountCurrency }}
            </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="isBusy" />

        <md-card-actions>
            <md-button class="md-primary" 
                        :disabled="!canRequestAmount" 
                        @click="requestAmount">
                Get amount
            </md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
    export default {
        name: "ProductSelector",
        props: {},
        data: () => ({
            isBusy: false,
            form: {
                taxNumber: '',
                productId: null,
            },
            error: null,
            formErrors: {},
            products: [],
            totalAmount: null,
            totalAmountCurrency: null
        }),
        computed: {
            canRequestAmount() {
                return !this.isBusy 
                    && this.form.taxNumber 
                    && this.form.productId;
            }
        },
        created: function() {
            this.loadProducts();
        },
        methods: {
            clearOutput() {
                this.formErrors = {};
                this.totalAmount = null;
                this.totalAmountCurrency = null;
            },
            loadProducts() {
                this.isBusy = true;
                fetch("/api/product/load-all")
                    .then(response => response.json())
                    .then(data => {
                        this.isBusy = false;
                        this.products = data.products;
                    });
            },
            requestAmount() {
                this.isBusy = true;
                this.clearOutput();

                const formData = new FormData();
                for(let k in this.form) {
                    formData.append('form['+k+']', this.form[k]);
                }
                fetch("/api/product/get-amount/"+this.form.productId, {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        this.isBusy = false;
                        if(data.error) {
                            alert(data.error);
                        }
                        this.formErrors = data.formErrors || {};
                        this.totalAmount = typeof data.amount === 'string' ? data.amount : null;
                        this.totalAmountCurrency = data.amountCurrency || null;
                    });
            }
        }
    }
</script>

<style scoped>
  .product-selector-card {
    max-width: 512px;
  }
</style>