package paquete;

public class Gato extends Animal {
	private boolean test_lucemia;
	public Gato(String numero_chip,String nombre,int edad, String raza, boolean adoptado, boolean test_lucemia) {
		super(numero_chip,nombre,edad,raza,adoptado);  // Llamamos al constructor de la clase Animal
		this.test_lucemia=test_lucemia; // Guardamos el test de lucemia
		
	}
	 // sobrescribimos el metodo mostrar y añadimos la informacion del gato
	@Override
	public void mostrar() {
		// TODO Auto-generated method stub
		System.out.println(" Chip: " +numero_chip);
		System.out.println(" Nombre: " +nombre);
		System.out.println(" Edad: " +edad);
		System.out.println("Raza: " +raza);
		System.out.println("Adoptado: "+adoptado);
		System.out.println("Test Leucemia: " +test_lucemia);
		}

}
