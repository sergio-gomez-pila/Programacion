package paquete;

public class Perro extends Animal {
	private String tamaño; // Tamaño del perro
	public Perro(String numero_chip,String nombre,int edad, String raza, boolean adoptado, String tamaño) {
		super(numero_chip,nombre,edad,raza,adoptado); // Llamamos al constructor de la clase Animal
		this.tamaño=tamaño; // Guardamos el tamaño
	}
 // sobrescribimos el metodo mostrar y añadimos la informacion del perro
	@Override
	public void mostrar() {
		// TODO Auto-generated method stub
		System.out.println(" Chip: " +numero_chip);
		System.out.println(" Nombre: " +nombre);
		System.out.println(" Edad: " +edad);
		System.out.println("Raza: " +raza);
		System.out.println("Adoptado: "+adoptado);
		System.out.println("Tamaño: " +tamaño);
		
	}

}
