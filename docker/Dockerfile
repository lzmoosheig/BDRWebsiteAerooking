FROM bitnami/postgresql:14

ADD ./0_create_user.sql /docker-entrypoint-initdb.d/0_create_user.sql
ADD ./1_Script_complet_v3.sql /docker-entrypoint-initdb.d/1_Script_complet_v3.sql