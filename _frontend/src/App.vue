<script setup lang="ts">
import { onMounted, ref, toRaw, reactive } from "vue";
import FormSetup from "@/components/FormSetup.vue";
import MoxiLog from "@/components/MoxiLog.vue";
import { IParams } from "@/types/params.type";
import { ApiResponse, ILogResponse } from "@/types/api.response.type";
import { Step } from "@/types/step.type";
import { EventData, IList } from "@/types/data.type";
import getData from "@/composables/get.data";
import sendEvent from "@/composables/send.event";

const showFormSetup = ref(false);
const isLoadSteps = ref(false);
const logs = reactive<ILogResponse>({
	error: [],
	warning: [],
	info: [],
});
const listParams = ref<IParams>();
const listSteps = ref<Step[]>();

onMounted(async () => {
	const res: ApiResponse = await getData();
	// const { success, data: dataSite, message }: ApiResponse = { success: false, message: "Авторизуйтесь в панели управления" };

	if(!res || !res.success || !res.data) {
		logs.error.push(res?.message || "Ошибка при получении данных!");
		return;
	}

	if(!res || typeof res === "undefined" || !("params" in res.data) || !("steps" in res.data)) {
		logs.error.push("Ошибка при получении данных!");
		console.error(res);
		return;
	}

	listParams.value = res.data.params;
	listSteps.value = res.data.steps;
	showFormSetup.value = true;
});

const addResLog = (res: ApiResponse, eventName?: string) => {
	const errorMessage = `Ошибка получения ответа от сервера. Событие: ${eventName || "???"}`;
	if(!res) {
		logs.error.push(errorMessage);
		console.error({res, eventName});
		return;
	}

	if(res.log) {
		const keysLog = Object.keys(res.log) as Array<keyof ILogResponse>;
		keysLog.forEach((typeLog) => logs[typeLog] && res.log && logs[typeLog].push(...res.log[typeLog]));
	}

	if(!res.success) {
		logs.error.push(res.message || errorMessage);
		console.error({res, eventName});
		return;
	}

	logs.info.push(res.message || `🏁 Завершено: ${eventName || "???"}`);
};

const processEvent = async (eventName: string, eventAction: string, eventData: EventData): Promise<void> => {
	logs.info.push(`🚀 ${eventName}`);
	const res = await sendEvent(eventAction, eventData);
	addResLog(res, eventName);
};

const sendData = async (dataList: IList) => {
	if(!dataList.addons || !listParams.value || !listSteps.value) { return; }
	const params: IParams = { ...toRaw(listParams.value), addons: dataList.addons };

	showFormSetup.value = false;
	isLoadSteps.value = true;

	if (dataList.siteName) {
		await processEvent("Изменение названия сайта", "setSiteName", dataList.siteName);
	}

	if (dataList.managerName) {
		await processEvent(`Изменение названия панели управления на ${dataList.managerName}`, "setManagerName", dataList.managerName);
	}

	for (const step of listSteps.value) {
		await processEvent(step.desc, step.name, step.name === "addons" ? params[step.name] : null);
	}

	if (dataList.removeApp) {
		await processEvent("Удаление Moxi", "removeApp", dataList.managerName);
	}

	isLoadSteps.value = false;
	logs.info.push("🏁🏁🏁 НАСТРОЙКА ЗАВЕРШЕНА 🏁🏁🏁");
};
</script>

<template>
	<div class="">
		<form-setup
			v-if="listParams && showFormSetup"
			:params="listParams"
			@send-data="sendData"
		/>
		<moxi-log
			:logs="logs"
			:load="isLoadSteps"
		/>
	</div>
</template>
