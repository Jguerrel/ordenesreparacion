<script setup>
import Layout from "@/Layouts/Layout.vue";
import CardVehicle from "../Vehicle/components/CardVehicle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { numberToDecimal } from "@/Utils/Common/common";
import {
    saveQuote,
    form,
    taxString,
    subtotal,
    total,
    hasZero,
    includeTax,
    validateFormat,
} from "./modules/create-quote";

const props = defineProps({
    order: Object,
});

// order_id
form.repair_order_id = props.order.id;

// inyecta cost
props.order.subcategories.forEach((sub) => {
    form.subs.push({
        id: sub.id,
        name: sub.name,
        cost: "",
    });
});
</script>
<template>
    <Head title="Cotización de vehículo" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 border-2 border-turquesa rounded-lg">
                    <div class="w-full pb-5">
                        <div class="flex justify-between items-center">
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Cotización
                            </h3>
                            <Link
                                :href="route('workshop_quotes.index')"
                                class="hover:no-underline bg-gray-700 px-3 py-2 hover:bg-gray-900 text-gray-50 rounded text-xs font-bold"
                            >
                                Listado cotizaciones
                            </Link>
                        </div>
                    </div>
                    <div class="w-full">
                        <div
                            class="bg-blue-800 text-white p-4 rounded text-left uppercase font-bold"
                        >
                            Taller
                            <span class="font-normal">
                                {{ order.workshop.name }}
                            </span>
                        </div>
                        <div class="py-5">
                            <CardVehicle :vehicle="order.vehicle" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div
                            class="bg-amber-600 text-white p-4 rounded text-center uppercase font-bold"
                        >
                            Cotización
                        </div>
                        <div class="py-5 w-full">
                            <!-- numero de cotización -->
                            <div
                                class="flex flex-row justify-between items-center pb-5 border-turquesa"
                            >
                                <div class="w-1/2">
                                    <p
                                        class="text-indigo-800 font-bold text-center text-lg"
                                    >
                                        Nº de cotización
                                    </p>
                                </div>
                                <div class="w-1/2 flex flex-col">
                                    <input
                                        type="text"
                                        v-model="form.number"
                                        placeholder="xxxxxx"
                                        class="w-full border border-indigo-500 rounded-md shadow-sm focus:border-indigo-800 focus:ring focus:ring-indigo-800 focus:ring-opacity-50"
                                        id="number_quote"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.number"
                                    />
                                </div>
                            </div>
                            <!-- tabla de items -->
                            <table class="min-w-full border border-gray-300">
                                <caption
                                    class="py-3 border-x border-t border-gray-300"
                                >
                                    <h5
                                        class="text-center text-zinc-800 font-bold text-2xl"
                                    >
                                        Desglose de items
                                    </h5>
                                </caption>
                                <thead class="border-b border-gray-300">
                                    <tr>
                                        <th class="text-center font-bold py-3">
                                            Item
                                        </th>
                                        <th class="text-center font-bold py-3">
                                            Costo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(sub, index) in form.subs"
                                        :key="sub.id"
                                        class="border border-gray-300"
                                    >
                                        <td
                                            class="text-center py-3 text-sm md:text-lg"
                                        >
                                            {{ sub.name }}
                                        </td>
                                        <td
                                            class="text-center py-3 text-sm md:text-lg"
                                        >
                                            <div
                                                class="flex justify-center items-center gap-2"
                                            >
                                                <span>$</span>
                                                <input
                                                    type="text"
                                                    v-model="sub.cost"
                                                    placeholder="1,200.00"
                                                    class="w-full border border-turquesa rounded-md shadow-sm focus:border-indigo-800 focus:ring focus:ring-indigo-800 focus:ring-opacity-50"
                                                    @input="
                                                        validateFormat(index)
                                                    "
                                                />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- total y subtotal -->
                            <div
                                class="flex flex-col justify-end py-5 border-t"
                            >
                                <div class="text-right p-3 text-sm md:text-lg">
                                    <label
                                        for="tax"
                                        class="cursor-pointer text-zinc-900 font-bold pr-1"
                                    >
                                        ¿Incluir impuesto?
                                    </label>
                                    <input
                                        type="checkbox"
                                        class="w-6 h-6 rounded-lg bg-gray-100 cursor-pointer"
                                        id="tax"
                                        v-model="includeTax"
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-right p-3 text-sm md:text-lg"
                                    >
                                        <b>Subtotal</b>
                                        <span class="bg-gray-100 p-3 rounded">
                                            ${{ numberToDecimal(subtotal) }}
                                        </span>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.subtotal"
                                        />
                                    </p>
                                </div>
                                <div>
                                    <div
                                        class="flex flex-col justify-end"
                                        :class="{
                                            'opacity-50': !includeTax,
                                            'pointer-events-none': !includeTax,
                                        }"
                                    >
                                        <p
                                            class="text-right p-3 text-sm md:text-lg"
                                        >
                                            <b>ITBMS</b>
                                            <span
                                                class="bg-gray-100 p-3 rounded"
                                            >
                                                {{ taxString }}
                                            </span>

                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.tax"
                                            />
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p
                                        class="text-right p-3 text-sm md:text-lg"
                                    >
                                        <b>Total</b>
                                        <span class="bg-gray-100 p-3 rounded">
                                            ${{ numberToDecimal(total) }}
                                        </span>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.total"
                                        />
                                    </p>
                                </div>
                            </div>

                            <ProgressBar
                                :form="form"
                                class="animate-fade-in-down mb-2"
                            />

                            <div class="flex justify-end">
                                <PrimaryButton
                                    type="button"
                                    class="px-7 py-4 text-lg uppercase"
                                    :class="{ 'opacity-50': hasZero }"
                                    :disabled="hasZero"
                                    @click.stop="saveQuote"
                                >
                                    Cotizar
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
