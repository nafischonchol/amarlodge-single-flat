let modules = [
    {
        name: "RBAC",
        permission: true,
        features: [
            {
                name: "User",
                permission: true,
                controls: [
                    {
                        name: "User Insert",
                        permission: false,
                    },
                    {
                        name: "User Edit",
                        permission: false,
                    },
                    {
                        name: "User Delete",
                        permission: true,
                    },
                    {
                        name: "User Insert",
                        permission: true,
                    },
                ],
            },
            {
                name: "Role",
                permission: false,
                controls: [
                    {
                        name: "Role Insert",
                        permission: false,
                    },
                    {
                        name: "Role Edit",
                        permission: true,
                    },
                ],
            },
        ],
    },
    {
        name: "Building",
        permission: false,
        features: [
            {
                name: "Building",
                permission: true,
                controls: [
                    {
                        name: "Building Insert",
                        permission: false,
                    },
                    {
                        name: "Building Edit",
                        permission: true,
                    },
                ],
            },
        ],
    },
];

export default modules;
