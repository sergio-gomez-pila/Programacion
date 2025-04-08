package paquete;

public abstract class Animal {
	protected String numero_chip; //identificador del chip para el animal
	protected String nombre; // Nombre del animal
	protected int edad; // Edad del animal
	protected String raza; // Raza del animal
	protected boolean adoptado; // indicar si esta adoptado
	// Constructor para guardar los atributos
	public Animal(String numero_chip,String nombre,int edad, String raza, boolean adoptado) {
		this.numero_chip=numero_chip;
		this.nombre=nombre;
		this.edad=edad;
		this.raza=raza;
		this.adoptado=adoptado;
		
	}
	// Metodo que devuelve el chip del animal
	public String getNumero_chip() {
		return numero_chip;
	}
	// Método abstracto para mostra info
	public abstract void mostrar();
	

}
