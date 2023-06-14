import { ApiResponse } from "@/types/api.response.type";
import { EventData } from "@/types/data.type";

export default async (step: string, items: EventData) => {
	try {
		const response = await fetch("web.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json"
			},
			body: JSON.stringify({ step, items })
		});
		const res: ApiResponse = await response.json();

		return res;
	} catch (error) {
		console.error(error);
	}
};
