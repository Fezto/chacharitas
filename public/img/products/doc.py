import os

# Crear 30 carpetas
for i in range(1, 31):
    folder_name = f"p_{i}"
    os.makedirs(folder_name, exist_ok=True)  # Crear carpeta si no existe
    print(f"Carpeta creada: {folder_name}")

print("¡Todas las carpetas fueron creadas!")
