CREATE TABLE access_rules (
    id UUID NOT NULL PRIMARY KEY,
    assignee_id UUID NOT NULL,
    assignee_type VARCHAR(64) NOT NULL,
    resource_id VARCHAR(64) NOT NULL,
    resource_type VARCHAR(64) NOT NULL,
    permission VARCHAR(64) NOT NULL
);