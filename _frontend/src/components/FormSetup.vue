<script setup lang="ts">
import { computed, reactive, ref, toRaw } from "vue";
import MoxiInput from "./MoxiInput.vue";
import MoxiBtn from "./MoxiBtn.vue";
import MoxiCheckbox from "./MoxiCheckbox.vue";
import { IParams, Addons } from "@/types/params.type";
import { IList } from "@/types/data.type";

const props = defineProps<{
	params: IParams,
}>();
const emit = defineEmits(["sendData"]);

const siteName = ref("");
const managerName = ref("");
const removeApp = ref(true);
const showAll = ref(false);
const addons: Addons = reactive("addons" in props.params ? JSON.parse(JSON.stringify(props.params.addons)) : {});
const sendData = computed<IList>(() => ({
	addons: toRaw(addons),
	siteName: siteName.value,
	managerName: managerName.value,
	removeApp: removeApp.value,
}));

const submitForm = () => emit("sendData", sendData.value);
</script>

<template>
	<form
		class="flex flex-col gap-10 mx-auto"
		@submit.prevent="submitForm"
	>
		<!--<div class="text-right">
			<moxi-checkbox
				v-model="showAll"
				label="Показать все параметры"
			/>
		</div>-->
		<pre
			v-if="showAll"
			class="overflow-x-auto rounded border p-4 bg-gray-600"
		>{{ params }}</pre>
		<template v-else>
			<moxi-input
				v-model="siteName"
				label="Название сайта"
				placeholder="Modx Revolution"
				note="Можно не заполнять"
			/>
			<moxi-input
				v-model="managerName"
				label="Переименовать панель управления"
				placeholder="manager"
				note="Можно не заполнять"
			/>
			<div
				v-if="addons"
				class=""
			>
				<h2 class="text-2xl">
					Дополнения:
				</h2>
				<div class="mt-5 grid grid-cols-1 lg:grid-cols-3 gap-x-10 gap-y-3">
					<template
						v-for="(items, provider) in params.addons"
						:key="provider"
					>
						<moxi-checkbox
							v-for="item in items"
							:key="provider+item"
							v-model="addons[provider]"
							:label="item"
						/>
					</template>
				</div>
			</div>
			<div class="text-center mt-8">
				<div class="mb-6">
					<moxi-checkbox
						v-model="removeApp"
						label="После окончания настройки удалить Moxi с сайта"
					/>
				</div>
				<moxi-btn
					label="Приступить к настройке"
					type="submit"
				/>
			</div>
		</template>
	</form>
</template>
