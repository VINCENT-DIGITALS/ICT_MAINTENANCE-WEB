ALTER TABLE lib_actions_taken
ADD COLUMN category_id BIGINT UNSIGNED NULL AFTER action_name,
ADD CONSTRAINT fk_category_id_actions_taken FOREIGN KEY (category_id) REFERENCES lib_categories(id) ON DELETE CASCADE;
