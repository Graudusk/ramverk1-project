--
-- Creating a sample table.
--


--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    -- "title" TEXT NOT NULL,
    "answer" TEXT NOT NULL,
    "user" INT,
    "question" INT,
    "created" TIMESTAMP,
    "updated" DATETIME
);
