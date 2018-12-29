--
-- Creating a sample table.
--



--
-- Table Tag
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "tag" TEXT NOT NULL,
    "slug" TEXT NOT NULL,
    "question" INTEGER
);
