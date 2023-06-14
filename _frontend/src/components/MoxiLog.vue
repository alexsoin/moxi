<script setup lang="ts">
import { ILogResponse } from "@/types/api.response.type";
import MoxiLoad from "./MoxiLoad.vue";
import MoxiModal from "./MoxiModal.vue";
import { watch, ref, computed } from "vue";

const props = defineProps<{
	logs: ILogResponse,
	load: boolean,
}>();

const showModal = ref(false);
const infoRef = ref<Element>();
const titleModal = ref("");
const dataModal = ref<string[]>([]);

const openModal = (title: string, data: string[]) => {
	showModal.value = true;
	titleModal.value = title;
	dataModal.value = data;
};

const showLog = computed(() => props.logs.error.length > 0 || props.logs.warning.length > 0 || props.logs.info.length > 0);

watch(props.logs.info, () => {
	if(infoRef.value) {
		setTimeout(() => {
			if(infoRef.value?.scrollHeight) {
				infoRef.value.scrollTop = infoRef.value.scrollHeight;
			}
		});
	}
});
</script>

<template>
	<div
		v-show="showLog"
		class="flex flex-col gap-10 my-10 p-4 bg-gray-900 bg-opacity-30 rounded"
	>
		<div class="flex flex-row gap-5 justify-end">
			<button
				class="border rounded border-red-800 bg-red-900 bg-opacity-40 text-yellow-100 px-4 py-2 hover:opacity-75"
				:disabled="!logs.error"
				@click.prevent="() => openModal('Ошибки:', logs.error)"
			>
				Ошибок ({{ logs.error.length }})
			</button>
			<button
				class="border rounded border-yellow-800 bg-yellow-900 bg-opacity-40 text-yellow-100 px-4 py-2 hover:opacity-75"
				:disabled="!logs.warning"
				@click.prevent="() => openModal('Предупреждения:', logs.warning)"
			>
				Предупреждений ({{ logs.warning.length }})
			</button>
		</div>
		<div v-if="logs.info.length > 0">
			<h2 class="text-2xl mb-5 flex gap-2 items-center">
				Прогресс:
				<moxi-load
					v-if="load"
					class="h-7 w-7 text-orange-600 opacity-70"
				/>
			</h2>
			<div
				ref="infoRef"
				class="flex flex-col gap-2 bg-gray-600 p-4 rounded max-h-96 overflow-x-auto"
			>
				<div
					v-for="info in logs.info"
					:key="'info-'+info"
					:class="{ 'text-yellow-100': info.includes('🏁') || info.includes('🚀') }"
				>
					{{ info }}
				</div>
			</div>
		</div>
	</div>
	<moxi-modal
		:show="showModal"
		:modal-title="titleModal"
		:modal-data="dataModal"
		@close-modal="() => showModal = false"
	/>
</template>
