import { ApiResponse } from "@/types/api.response.type";

export default async () => {
	try {
		const response = await fetch("web.php");
		const data: ApiResponse = await response.json();

		return data;
	} catch (error) {
		console.error(error);
	}
};
