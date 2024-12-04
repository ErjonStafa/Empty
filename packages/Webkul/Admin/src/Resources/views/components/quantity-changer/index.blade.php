@props([
    'name'  => '',
    'value' => 1,
    'step' => 1
])

<v-quantity-changer
    {{ $attributes->merge(['class' => 'flex items-center border dark:border-gray-300']) }}
    name="{{ $name }}"
    value="{{ $value }}"
    step="{{ $step }}"
>
</v-quantity-changer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-quantity-changer-template"
    >
        <div>
            <span
                class="cursor-pointer text-2xl dark:text-gray-300"
                @click="decrease"
            >
                -
            </span>

            <p class="w-2.5 select-none text-center dark:text-gray-300">
                @{{ quantity }}
            </p>

            <span
                class="cursor-pointer text-2xl dark:text-gray-300"
                @click="increase"
            >
                +
            </span>

            <v-field
                type="hidden"
                :name="name"
                v-model="quantity"
                :step="step"
            ></v-field>
        </div>
    </script>

    <script type="module">
        app.component("v-quantity-changer", {
            template: '#v-quantity-changer-template',

            props:['name', 'value', 'step'],

            data() {
                return  {
                    quantity: ((parseInt(this.value) % parseInt(this.step) !== 0) ? this.step : this.value),
                }
            },

            watch: {
                value() {
                    this.quantity = this.value;
                },
            },

            methods: {
                increase() {
                    this.$emit('change', this.quantity = parseInt(this.quantity) + parseInt(this.step));
                },

                decrease() {
                    if (this.quantity > 1 && (this.quantity - this.step) > 0) {
                        this.quantity -= this.step;

                        this.$emit('change', this.quantity);
                    }
                },
            }
        });
    </script>
@endpushOnce
