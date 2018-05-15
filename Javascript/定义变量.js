var SugPara, uigs_para, 
	msBrowserName = navigator.userAgent.toLowerCase(),
	msIsSe = false,
	msIsMSearch = false,
	queryinput = document.getElementById("query");

uigs_para = {
	uigs_productid: "webapp",
	type: "webindex",
	scrnwi: screen.width,
	scrnhi: screen.height,
	uigs_pbtag: "A",
	uigs_cookie: "SUID,sct"
};
SugPara = {
	enableSug: true,
	sugType: "web",
	domain: "w.sugg.sogou.com",
	productId: "web",
	sugFormName: "sf",
	inputid: "query",
	submitId: "stb",
	suggestRid: "01015002",
	normalRid: "01019900",
	useParent: 0
};